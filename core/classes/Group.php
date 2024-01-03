<?php

class Group {  //Array

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Method to create a new group
    public function createGroup($groupName, $description, $creatorUserId , $type ) {
        // Implementation to insert group data into the database

        try {
            // SQL query to insert group data into the database
            $sql = "INSERT INTO groups (group_name, description, creator_user_id , type , banner , profile_img) 
                    VALUES (:group_name, :description, :creator_user_id , :type , 'assets/images/defaultCoverImage.png' , 'assets/images/defaultgroupprofileimage.png')";

            // Prepare the SQL statement
            $stmt = $this->pdo->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':group_name', $groupName);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':creator_user_id', $creatorUserId);
            $stmt->bindParam(':type', $type);

            // Execute the prepared statement
            $stmt->execute();

            // Return the last inserted ID (if needed)
            return $this->pdo->lastInsertId();

        } catch (PDOException $e) {
            // Handle the exception (e.g., log error, return a specific value, etc.)
            echo "Error: " . $e->getMessage();
            return false; // or throw an exception
        }
    }

    // Method to retrieve information about a specific group
    public function getGroupDetails($group_id) {
        // Implementation to fetch group details from the database

        $stmt = $this->pdo->prepare('SELECT * FROM `groups` WHERE `group_id` = :group_id');
        $stmt->bindParam(':group_id', $group_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    // Method to add a user to a group
    public function addUserToGroup($userId, $groupId) {
        // Implementation to insert user-group relationship into the database
    }

    // Method to remove a user from a group
    public function removeUserFromGroup($userId, $groupId) {
        // Implementation to delete user-group relationship from the database
    }

    // Method to retrieve a list of groups a user is a member of
    public function getUserGroups($userId) {
        // Implementation to fetch user groups from the database
    }

    // Method to retrieve a list of group members
    public function getGroupMembers($groupId) {
        // Implementation to fetch group members from the database
    }

    // Method to post content within a group
    public function postInGroup($userId, $groupId, $content) {
        // Implementation to insert group post into the database
    }

    // Method to retrieve group posts
    public function getGroupPosts($groupId) {
        // Implementation to fetch group posts from the database
    }

    // Method to search for groups based on certain criteria
    public function searchGroups($searchQuery) {
        // Implementation to search for groups in the database
    }

    // Method to update group information
    public function updateGroupInfo($groupId, $newGroupName, $newDescription) {
        // Implementation to update group information in the database
    }

    // Method to delete a group
    public function deleteGroup($groupId) {
        // Implementation to delete a group and associated data from the database
    }
}
