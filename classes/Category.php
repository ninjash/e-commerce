<?php
class Category {
    private $db;
    private $id;
    private $name;
    private $description;
    private $parentId;
    private $featured;
    private $imagePath;

    public function __construct($db, $id = null) {
        $this->db = $db;
        if ($id) {
            $this->getCategoryById($id);
            $this->imagePath = $this->getCategoryImage($id); // Fetch category image if available
        }
    }

    // Fetch a single category by ID
    public function getCategoryById($id) {
        $query = "SELECT * FROM categories WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $category = $result->fetch_assoc();

        if ($category) {
            $this->id = $category['id'];
            $this->name = $category['name'];
            $this->description = $category['description'];
            $this->parentId = $category['parent_id'];
            $this->featured = $category['featured'];
        }
    }

    // Fetch category details by category ID
    public function getCategoryDetails($categoryId) {
        $query = "SELECT c1.id, c1.name AS category_name, c2.name AS parent_name, c3.name AS grandparent_name
                  FROM categories c1
                  LEFT JOIN categories c2 ON c1.parent_id = c2.id
                  LEFT JOIN categories c3 ON c2.parent_id = c3.id
                  WHERE c1.id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            die('Error executing query: ' . $this->db->error);
        }

        return $result->fetch_assoc(); // Return associative array
    }

     // Fetch featured categories
     public function getFeaturedCategories($limit) {
        $query = "SELECT c.id, c.name, ci.image_path
                  FROM categories c
                  LEFT JOIN category_images ci ON c.id = ci.category_id
                  WHERE c.featured = 1
                  LIMIT ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            die('Error executing query: ' . $this->db->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC); // Return array of featured categories
    }

    // Method to fetch trending categories
    public function getTrendingCategories() {
        $query = "
            SELECT DISTINCT c.id, c.name
            FROM categories c
            JOIN product_categories pc ON c.id = pc.category_id
            JOIN products p ON pc.product_id = p.id
            WHERE p.feature_product = 1
            ORDER BY c.name ASC
        ";

        $result = $this->db->query($query);

        if (!$result) {
            throw new Exception('Error fetching trending categories: ' . $this->db->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC); // Return as an associative array
    }
    
    // Fetch only child category IDs based on the parent ID
    public function getChildCategories($parentId) {
        $query = "SELECT id FROM categories WHERE parent_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $parentId);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            die('Error executing query: ' . $this->db->error);
        }

        $categories = $result->fetch_all(MYSQLI_ASSOC);
        return array_column($categories, 'id'); // Return array of category IDs
    }

    // Fetch the image for a category, if exists
    public function getCategoryImage($categoryId) {
        $query = "SELECT image_path FROM category_images WHERE category_id = ? LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            die('Error executing query: ' . $this->db->error);
        }

        $image = $result->fetch_assoc();
        // Ensure the path to the default image is correct
        return $image && !empty($image['image_path']) ? $image['image_path'] : '/e-commerce/assets/category_images/no-image-available.png';
    }

    // Fetch main categories (categories without a parent)
    public static function getMainCategories($db) {
        $query = "SELECT c.id, c.name, c.description,
                        (SELECT COUNT(p.id)
                        FROM product_categories pc
                        JOIN products p ON pc.product_id = p.id
                        WHERE pc.category_id = c.id 
                            OR pc.category_id IN (SELECT id FROM categories WHERE parent_id = c.id)
                            OR pc.category_id IN (SELECT id FROM categories WHERE parent_id IN (SELECT id FROM categories WHERE parent_id = c.id))
                        ) AS product_count
                FROM categories c
                WHERE c.parent_id IS NULL";
        
        $result = $db->query($query);

        if (!$result) {
            die('Error executing query: ' . $db->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC); // Return as array
    }

    // Fetch second-level categories (child categories of a given main category)
    public static function getSecondLevelCategories($db, $parentId) {
        $query = "SELECT c.id, c.name, c.description, c2.name AS parent_name,
                         (SELECT COUNT(p.id)
                          FROM product_categories pc
                          JOIN products p ON pc.product_id = p.id
                          WHERE pc.category_id = c.id
                             OR pc.category_id IN (SELECT id FROM categories WHERE parent_id = c.id)
                         ) AS product_count
                  FROM categories c
                  LEFT JOIN categories c2 ON c.parent_id = c2.id
                  WHERE c.parent_id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $parentId);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if (!$result) {
            die('Error executing query: ' . $db->error);
        }
    
        return $result->fetch_all(MYSQLI_ASSOC); // Return as array
    }    

    // Fetch third-level categories (child categories of a second-level category)
    public static function getThirdLevelCategories($db, $parentId) {
        $query = "SELECT c.id, c.name, c.description, c2.name AS parent_name,
                         (SELECT COUNT(p.id)
                          FROM product_categories pc
                          JOIN products p ON pc.product_id = p.id
                          WHERE pc.category_id = c.id
                         ) AS product_count
                  FROM categories c
                  LEFT JOIN categories c2 ON c.parent_id = c2.id
                  WHERE c.parent_id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $parentId);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if (!$result) {
            die('Error executing query: ' . $db->error);
        }
    
        return $result->fetch_all(MYSQLI_ASSOC); // Return as array
    }    

    // Recursive function to fetch all child categories
    public static function getAllChildCategories($db, $parentId) {
        $childCategories = [];
        
        $query = "SELECT id FROM categories WHERE parent_id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $parentId);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            die('Error executing query: ' . $db->error);
        }

        while ($row = $result->fetch_assoc()) {
            $childCategories[] = $row['id'];
            $childCategories = array_merge($childCategories, self::getAllChildCategories($db, $row['id']));
        }

        return $childCategories;
    }

    public function getAllCategories() {
        $query = "SELECT * FROM categories ORDER BY name ASC";
        $result = $this->db->query($query);
        if (!$result) {
            die('Error fetching categories: ' . $this->db->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Fetch second-level categories (child categories of a given main category) with parent names
    public static function getSecondLevelCategoriesWithParentNames($db) {
        $query = "SELECT c.id, c.name, c.description, c2.name AS parent_name
                FROM categories c
                LEFT JOIN categories c2 ON c.parent_id = c2.id
                WHERE c.parent_id IS NOT NULL AND c2.parent_id IS NULL";
        $result = $db->query($query);

        if (!$result) {
            die('Error executing query: ' . $db->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC); // Return as array
    }

    // Fetch third-level categories (child categories of a second-level category) with parent names
    public static function getThirdLevelCategoriesWithParentNames($db) {
        $query = "SELECT c.id, c.name, c.description, c2.name AS parent_name
                FROM categories c
                LEFT JOIN categories c2 ON c.parent_id = c2.id
                WHERE c.parent_id IS NOT NULL AND c2.parent_id IS NOT NULL";
        $result = $db->query($query);

        if (!$result) {
            die('Error executing query: ' . $db->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC); // Return as array
    }

    // Getters and Setters for category details
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getParentId() {
        return $this->parentId;
    }

    public function setParentId($parentId) {
        $this->parentId = $parentId;
    }

    public function getFeatured() {
        return $this->featured;
    }

    public function setFeatured($featured) {
        $this->featured = $featured;
    }

    public function getImagePath() {
        return $this->imagePath;
    }

    // Save a new category to the database
    public function save() {
        $query = "INSERT INTO categories (name, description, parent_id, featured) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssii", $this->name, $this->description, $this->parentId, $this->featured);
        return $stmt->execute();
    }

    // Update an existing category in the database
    public function update() {
        $query = "UPDATE categories SET name = ?, description = ?, parent_id = ?, featured = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssiii", $this->name, $this->description, $this->parentId, $this->featured, $this->id);
        return $stmt->execute();
    }

    // Delete a category by ID
    public function delete() {
        $query = "DELETE FROM categories WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

    // Fetch categories with parent names
    public function getCategoriesWithParentNames() {
        $query = "SELECT c1.id, c1.name, c1.description, c2.name AS parent_name
                  FROM categories c1
                  LEFT JOIN categories c2 ON c1.parent_id = c2.id";
        $result = $this->db->query($query);

        if (!$result) {
            die('Error executing query: ' . $this->db->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}