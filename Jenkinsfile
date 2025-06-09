pipeline {
    // Menentukan pipeline bisa berjalan di agent Jenkins mana saja
    agent any

    // Variabel lingkungan untuk mempermudah pengelolaan
    environment {
        USER      = 'jenkins-agent'
        HOST      = '100.94.10.64' // <-- GANTI INI
        PROJECT_PATH = '/var/www/html/lets-input' // <-- GANTI INI
        DB_NAME = 'letsinput'
    }

    stages {
        stage('Checkout Code') {
            steps {
                // Jenkins otomatis mengambil kode dari repo yang memicu job ini
                echo 'Checking out code...'
                checkout scm
            }
        }

        stage('Backup Database') {
            steps {
                sshagent(credentials: ['vm-ssh-key']) {
                    sh """
                        ssh -o StrictHostKeyChecking=no ${USER}@${HOST} '
                            echo "--- MEMULAI PROSES BACKUP DATABASE ---"

                            # Tentukan lokasi penyimpanan backup di VM
                            BACKUP_PATH="/home/${USER}/db_backups"
                            mkdir -p \$BACKUP_PATH

                            # Buat nama file dinamis menggunakan perintah date di Linux
                            FILENAME="backup_\$(date +%Y%m%d_%H%M%S).sql.gz"

                            echo "Membuat backup: \$FILENAME di lokasi \$BACKUP_PATH"
                                
                            # Jalankan mysqldump di VM dan kompres hasilnya
                            # Kredensial dibaca dari ~/.my.cnf (lebih aman)
                            mysqldump ${DB_NAME} | gzip > \$BACKUP_PATH/\$FILENAME

                            echo "--- BACKUP DATABASE SELESAI ---"

                            # Opsional: Hapus backup yang lebih tua dari 7 hari
                            echo "Menghapus backup yang lebih tua dari 7 hari..."
                            find \$BACKUP_PATH -type f -mtime +7 -name '*.sql.gz' -delete
                        '
                    """
                }
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
