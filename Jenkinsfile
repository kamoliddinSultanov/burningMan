pipeline {
    agent any

    stages {
        stage('Checkout Code') {
            steps {
                echo 'Cloning the repository...'
                git branch: 'master', url: 'https://github.com/kamoliddinSultanov/burningMan.git'
            }
        }
        stage('Install Dependencies') {
            steps {
                echo 'Installing PHP dependencies...'
                bat 'composer install'
            }
        }
        stage('Run Tests') {
            steps {
                echo 'Running PHPUnit tests...'
                bat '.\\vendor\\bin\\phpunit --configuration phpunit.xml'
            }
        }
        stage('Build Docker Image') {
            steps {
                echo 'Building Docker image...'
                bat 'docker build -t php-app .'
            }
        }
        stage('Deploy Application') {
            steps {
                echo 'Deploying the application...'
                bat 'docker-compose up -d'
            }
        }
    }
    post {
        success {
            echo 'Pipeline completed successfully!'
        }
        failure {
            echo 'Pipeline failed. Please check the logs.'
        }
    }
}
