<?php
class Manufacturer {
    private $db;
    private $id;
    private $name;
    private $logoPath;
    private $specialty;

    public function __construct($db, $id = null) {
        $this->db = $db;
        if ($id) {
            $this->getManufacturerById($id);
        }
    }

    // Fetch manufacturer details by ID
    public function getManufacturerById($id) {
        $query = "SELECT * FROM manufacturers WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $manufacturer = $result->fetch_assoc();

        if ($manufacturer) {
            $this->id = $manufacturer['id'];
            $this->name = $manufacturer['name'];
            $this->logoPath = $manufacturer['logo_path'];
            $this->specialty = $manufacturer['specialty'];
        }
    }

    // Method to fetch top manufacturers with a limit
    public function getTopManufacturers($limit) {
        $query = "SELECT id, name, logo_path FROM manufacturers LIMIT ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            throw new Exception('Error fetching top manufacturers: ' . $this->db->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC); // Return array of top manufacturers
    }

    // Method to fetch all manufacturers with product count
    public function getAllManufacturersWithProductCount() {
        $query = "SELECT m.id, m.name, m.specialty, m.logo_path, COUNT(p.id) AS product_count 
                  FROM manufacturers m
                  LEFT JOIN products p ON m.id = p.manufacturer_id
                  GROUP BY m.id";
        $result = $this->db->query($query);

        if (!$result) {
            throw new Exception('Error fetching manufacturers: ' . $this->db->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Method to save or update a manufacturer
    public function save() {
        if ($this->id) {
            // Update existing manufacturer
            $query = "UPDATE manufacturers SET name = ?, specialty = ?, logo_path = ? WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("sssi", $this->name, $this->specialty, $this->logoPath, $this->id);
        } else {
            // Insert new manufacturer
            $query = "INSERT INTO manufacturers (name, specialty, logo_path) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("sss", $this->name, $this->specialty, $this->logoPath);
        }

        if (!$stmt->execute()) {
            throw new Exception('Error saving manufacturer: ' . $stmt->error);
        }

        // Set the ID for the newly inserted manufacturer
        if (!$this->id) {
            $this->id = $this->db->insert_id;
        }
    }

    // Getters for manufacturer details
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getLogoPath() {
        return $this->logoPath;
    }

    public function getSpecialty() {
        return $this->specialty;
    }

    // Setters for manufacturer details
    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setLogoPath($logoPath) {
        $this->logoPath = $logoPath;
    }

    public function setSpecialty($specialty) {
        $this->specialty = $specialty;
    }
}