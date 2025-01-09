pipeline {
    agent any  

    stages {
        stage('Checkout') {
            steps {
                script {

                    checkout scm
                }
            }
        }

        stage('Test Git') {
            steps {
                script {

                    bat 'git --version'
                }
            }
        }
    }
}
