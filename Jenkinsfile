pipeline {
    // Menentukan pipeline bisa berjalan di agent Jenkins mana saja
    agent any

    // Variabel lingkungan untuk mempermudah pengelolaan
    environment {
        USER      = 'jenkins-agent'
        HOST      = '100.94.10.64' // <-- GANTI INI
        PROJECT_PATH = '/var/www/html/lets-input' // <-- GANTI INI
    }

    stages {
        stage('Checkout Code') {
            steps {
                // Jenkins otomatis mengambil kode dari repo yang memicu job ini
                echo 'Checking out code...'
                checkout scm
            }
        }

        stage('Deploy to Production VM') {
            steps {
                // Menggunakan kredensial SSH yang sudah kita simpan
                sshagent(credentials: ['vm-ssh-key']) {
                    script {
                        // Menjalankan blok perintah di dalam koneksi SSH ke VM
                        sh """
                            ssh -o StrictHostKeyChecking=no ${USER}@${HOST} '
                                echo "--- MENGHUBUNGKAN KE VM ---"
                                cd ${PROJECT_PATH}
                                
                                echo "--- MENGAKTIFKAN MAINTENANCE MODE ---"
                                php artisan down || true

                                echo "--- MENARIK KODE TERBARU DARI GIT ---"
                                git pull origin main

                                echo "--- MENGINSTALL DEPENDENSI COMPOSER ---"
                                composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader

                                echo "--- MENJALANKAN MIGRATIONS DATABASE ---"
                                php artisan migrate --force

                                echo "--- MEMBERSIHKAN CACHE ---"
                                php artisan optimize:clear
                                php artisan config:cache
                                php artisan route:cache
                                php artisan view:cache

                                echo "--- MENONAKTIFKAN MAINTENANCE MODE ---"
                                php artisan up
                                
                                echo "--- DEPLOYMENT SELESAI ---"
                            '
                        """
                    }
                }
            }
        }
    }
    
    post {
        // Blok yang selalu dijalankan setelah pipeline selesai
        always {
            echo 'Pipeline selesai.'
            // Membersihkan workspace Jenkins setelah build
            cleanWs()
        }
    }
}
