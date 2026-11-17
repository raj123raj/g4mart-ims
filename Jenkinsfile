
pipeline {
    agent any

    environment {
        PHP_PATH         = 'D:\\Priya\\softwares\\php\\php.exe'
        COMPOSER_PATH    = 'D:\\Priya\\softwares\\composer\\composer.bat'
        MYSQL_PATH       = 'C:\\Program Files\\MySQL\\MySQL Server 5.7\\bin\\mysql.exe'
        LOCAL_DEPLOYPATH = 'D:\\Xampp1\\htdocs\\g4mart-ims-main'
        PHP_DIR          = 'D:\\Priya\\softwares\\php'
        TEST_DB          = 'g4mart_ims_test'
    }

    stages {

        // 1. Get source code from GitHub main branch
        stage('Checkout') {
            steps {
                git branch: 'main',
                    credentialsId: 'github-raj123raj',
                    url: 'https://github.com/raj123raj/g4mart-ims.git'
            }
        }

        // 2. Install Laravel dependencies
        stage('Dependencies') {
            steps {
                bat """
                    set "PATH=%PHP_DIR%;%PATH%"
                    "%PHP_PATH%" -v
                    dir composer.json
                    call "%COMPOSER_PATH%" install --no-progress --no-interaction
                """
            }
        }

        // 3. Configure Laravel environment
        stage('Environment') {
            steps {
                bat """
                    if not exist .env copy .env.example .env
                    "%PHP_PATH%" artisan key:generate --force
                    "%PHP_PATH%" artisan config:clear
                """
            }
        }

        // 4. Prepare separate testing database
        stage('Test DB') {
            steps {
                bat """
                    "%MYSQL_PATH%" -h 127.0.0.1 -u root -e "CREATE DATABASE IF NOT EXISTS %TEST_DB%;"

                    "%PHP_PATH%" artisan config:clear --env=testing

                    "%PHP_PATH%" artisan migrate:fresh --seed --env=testing
                """
            }
        }

        // 5. Execute Laravel automated tests
        stage('Test') {
            steps {
                bat """
                    "%PHP_PATH%" artisan test
                """
            }
        }



        // 7. Deploy application to local XAMPP folder
        stage('Deploy Local') {
            steps {
                bat """
                    if not exist "%LOCAL_DEPLOYPATH%" mkdir "%LOCAL_DEPLOYPATH%"

                    robocopy "%WORKSPACE%" "%LOCAL_DEPLOYPATH%" /E /R:2 /W:5 ^
                        /XD .git node_modules ^
                        /XF .env .env.example .env.testing Jenkinsfile exclude.txt ^
                        /NFL /NDL

                    if errorlevel 8 exit /b %ERRORLEVEL%

                    exit /b 0
                """
            }
        }
    }
}
