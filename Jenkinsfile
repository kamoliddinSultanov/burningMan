pipeline {
    agent any

    tools {
        git 'Git for Jenkins'
    }

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
                    
                    sh 'git --version'
                }
            }
        }
    }
}
