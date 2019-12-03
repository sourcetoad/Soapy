pipeline {
  agent {
    dockerfile true
  }
  stages {
    stage('Build') {
      steps {
        sh 'composer install --ignore-platform-reqs'
        stash includes: 'vendor/**', name: 'vendor'
      }
    }
    stage('Test') {
      steps {
        unstash 'vendor'
        sh './vendor/bin/phpunit'
      }
    }
  }
}
