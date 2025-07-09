<?php
    class DataBaseCredentials
    {
        public const DB_USERNAME = "your username";
        public const DB_PASSWORD = "your password";

        public const DB_HOST = "localhost";
        public const DB_PORT = "1521";
        public const SID = "SID";

        public const TNS = "(DESCRIPTION =
                    (ADDRESS_LIST =
                    (ADDRESS = (PROTOCOL = TCP)(HOST = ".self::DB_HOST.")
                    (PORT = ".self::DB_PORT.")))
                    (CONNECT_DATA =
                    (SID = ".self::SID.")
                    )
                )";

    }
?>