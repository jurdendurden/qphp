<?php

    class user
    {
        public $id;
        public $name;
        public $email;

        public bool $admin;

        function __construct()
        {
            
        }

        function select_user_by_name($name)
        {
            global $db;
            $query = 'SELECT * FROM users
                        WHERE name = :name';
            
            $statement = $db->prepare($query);            
            $statement->bindValue(':name', $name);            
            $statement->execute();
            $results = $statement->fetchAll();
            $statement->closeCursor();
            return $results;
        }

        function select_user_by_id($id)
        {
            global $db;
            $query = 'SELECT * FROM users
                        WHERE id = :id';
            
            $statement = $db->prepare($query);           
            $statement->bindValue(':id', $id);            
            $statement->execute();
            $results = $statement->fetchAll();
            $statement->closeCursor();
            return $results;                      
        }

        function insert_user($name, $admin)
        {
            global $db;

            $count = 0;

            $query = 'INSERT INTO users
                    (name,admin)
                    VALUES
                    (:name, :admin)';

            $statement = $db->prepare($query);
            $statement->bindValue(':name', $name);            
            $statement->bindValue(':admin', $admin);        
            if ($statement->execute())
            {
                $count = $statement->rowCount();
                if ($count == 0)
                {
                    //error
                }
            }
            $statement->closeCursor();
            return $count;
        }

        function update_user($name, $admin, $id)
        {
            global $db;

            $count = 0;

            $query = 'UPDATE user
                SET name = :name, admin = :admin
                WHERE id = :id';

            $statement = $db->prepare($query);
            $statement->bindValue(':name', $name);            
            $statement->bindValue(':admin', $admin);   
            $statement->bindValue(':id', $id);   
            if ($statement->execute())
            {
                $count = $statement->rowCount();
            }         
            $statement->closeCursor();
            return $count;
        }

        function delete_user($id)
        {
            global $db;
            $count = 0;

            $query = 'DELETE FROM users WHERE id = :id';
            $statement = $db->prepare($query);
            $statement->bindValue(':id', $id);   
            if ($statement->execute())
            {
                $count = $statement->rowCount();                
            }
            $statement->closeCursor();
            return $count;
        }

    }
?>