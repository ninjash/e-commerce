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
        $stmt->bind_param("i", $id); // "i" for integer
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
        $stmt->bind_param("i", $categoryId); // Bind category ID to the query
        $stmt->execute();
        $result = $stmt->get_result();
        
        if (!$result) {
            die('Error executing query: ' . $this->db->error); // Add error handling
        }

        return $result; // Return MySQLi result object
    }

    // Fetch only child category IDs based on the parent ID
    public function getChildCategories($parentId) {
        $query = "SELECT id FROM categories WHERE parent_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $parentId);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            die('Error executing query: ' . $this->db->error); // Add error handling
        }

        $categories = $result->fetch_all(MYSQLI_ASSOC);
        $categoryIds = array_column($categories, 'id');
        return $categoryIds;
    }

    // Fetch the image for a category, if exists
    public function getCategoryImage($categoryId) {
        $query = "SELECT image_path FROM category_images WHERE category_id = ? LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $categoryId); // "i" for integer
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            die('Error executing query: ' . $this->db->error); // Add error handling
        }

        $image = $result->fetch_assoc();
        return $image ? $image['image_path'] : '/e-commerce/assets/category_images/default-category.png'; // Default image if not found
    }

    // Fetch products by category IDs
    public static function getProductsByCategory($categoryIds, $db) {
        $query = "SELECT p.*, pi.image_path 
                FROM products p
                JOIN product_categories pc ON p.id = pc.product_id
                LEFT JOIN product_images pi ON p.id = pi.product_id
                WHERE pc.category_id IN ($categoryIds)";
                
        $result = $db->query($query);

        if (!$result) {
            die('Error executing query: ' . $db->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC); // Return array format instead of result object
    }

    // Fetch all products
    public static function getAllProducts($db) {
        $query = "SELECT p.*, pi.image_path 
                FROM products p
                LEFT JOIN product_images pi ON p.id = pi.product_id";
                
        $result = $db->query($query);

        if (!$result) {
            die('Error executing query: ' . $db->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC); // Return array format instead of result object
    }

    // Fetch main categories (categories without a parent)
    public static function getMainCategories($db) {
        $query = "SELECT c.id, c.name, 
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

        return $result->fetch_all(MYSQLI_ASSOC); // Return array format instead of result object
    }

    // Fetch second-level categories
    public static function getSecondLevelCategories($db, $parentId) {
        $query = "SELECT c.id, c.name, 
                        (SELECT COUNT(p.id) 
                        FROM product_categories pc
                        JOIN products p ON pc.product_id = p.id
                        WHERE pc.category_id = c.id 
                            OR pc.category_id IN (SELECT id FROM categories WHERE parent_id = c.id)
                        ) AS product_count
                FROM categories c 
                WHERE c.parent_id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $parentId);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            die('Error executing query: ' . $db->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC); // Return array format instead of result object
    }

    // Fetch third-level categories
    public static function getThirdLevelCategories($db, $parentId) {
        $query = "SELECT c.id, c.name, 
                        (SELECT COUNT(p.id) 
                        FROM product_categories pc
                        JOIN products p ON pc.product_id = p.id
                        WHERE pc.category_id = c.id
                        ) AS product_count
                FROM categories c 
                WHERE c.parent_id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $parentId);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            die('Error executing query: ' . $db->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC); // Return array format instead of result object
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
            die('Error executing query: ' . $db->error); // Add error handling
        }

        while ($row = $result->fetch_assoc()) {
            $childCategories[] = $row['id'];
            $childCategories = array_merge($childCategories, self::getAllChildCategories($db, $row['id']));
        }

        return $childCategories;
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
            die('Error executing query: ' . $this->db->error); // Add error handling
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}