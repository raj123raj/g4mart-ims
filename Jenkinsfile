pipeline {
    agent any

    environment {
        PHP_PATH       = 'D:\\Priya\\softwares\\php\\php.exe'
        COMPOSER_PATH  = 'D:\\Priya\\softwares\\composer\\composer.bat'
        LOCAL_DEPLOYPATH = 'D:\\Xampp1\\htdocs\\g4mart-ims'
		MYSQL_PATH = 'C:\\Program Files\\MySQL\\MySQL Server 5.7\\bin\\mysql.exe'
    }

    stages {
        stage('Checkout') {
            steps {
                git branch: 'main',
                    credentialsId: 'github-raj123raj',
                    url: 'https://github.com/raj123raj/g4mart-ims'
            }
        }

        stage('Dependencies') {
            steps {
                // Verify composer.json exists in workspace
                bat 'dir composer.json'         
                
                // Install PHP dependencies -> creates vendor/autoload.php
                bat "%COMPOSER_PATH% install --no-progress --no-interaction"
				
            }
        }

      stage('Environment') {
    steps {
        bat """
        copy /Y .env.example .env
        "%PHP_PATH%" artisan key:generate --force
        """
    }
}


        stage('Test DB') {
    steps {
        bat """
            "%MYSQL_PATH%" -h 127.0.0.1 -u root -e "CREATE DATABASE IF NOT EXISTS g4mart_ims;"
            "%PHP_PATH%" artisan config:clear
            "%PHP_PATH%" artisan migrate:fresh --seed --env=testing
        """
    }
}

        stage('Test') {
            steps {
                bat "\"%PHP_PATH%\" artisan test"
            }
        }

		stage('Deploy Local') {
			steps {
				bat """
					if not exist "%LOCAL_DEPLOYPATH%" mkdir "%LOCAL_DEPLOYPATH%"

					robocopy "%WORKSPACE%" "%LOCAL_DEPLOYPATH%" /E /R:2 /W:5 ^
						/XD .git node_modules ^
						/XF .env .env.example Jenkinsfile exclude.txt ^
						/NFL /NDL

					set "RC=%ERRORLEVEL%"
					if %RC% GEQ 8 exit /b %RC%
					exit /b 0
				"""
			}
		}}


    }


}