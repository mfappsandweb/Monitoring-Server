<?php
    require "../config/db-config.php";

    class MySQL_Server_Connection {

        // Connect to DB
        private function connect() {
            return new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
        }

        // Run SQL query
        public function runSQLQuery($sql) {

            // Open DB
            $db = $this->connect();

            // Run & return query
            $response = $db->query($sql);
            if( is_bool($response) ) {
                $response = ($response) ? 'true' : 'false';
            }

            switch($response) {

                case "true":
                    $data['response'] = true;
                    $data['error'] = null;
                    return $data;

                case "false":
                    $data['response'] = false;
                    $data['error'] = $db->error;
                    return $data;

                default:
                    $data['response'] = true;
                    $data['error'] = null;
	    			if( $response->num_rows > 0) {
                        while( $row = $response->fetch_assoc() ) {
                            $data['rows'][] = $row;
                        }
	    			}
	    			else {
	    				$data['rows'] = null;
                    }
                    return $data;
                    
            }
        }
    }
?>