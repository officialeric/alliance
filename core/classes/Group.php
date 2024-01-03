<?php

class Group {  //Array

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Method to create a new group
    public function createGroup($groupName, $description, $creatorUserId , $type ) {
        // Implementation to insert group data into the database
    }

    // Method to retrieve information about a specific group
    public function getGroupDetails($groupId) {
        // Implementation to fetch group details from the database
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
