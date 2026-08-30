# ==============================================================================
#  inhealtcare (SIMRS) - Docker Orchestration Makefile
# ==============================================================================
#  Jalankan `make` atau `make help` untuk melihat semua perintah.
#
#  Stack: nginx:alpine (port 9090) -> php:7.4-fpm-alpine -> PostgreSQL (eksternal)
# ==============================================================================

# --- Konfigurasi -------------------------------------------------------------
SHELL           := /bin/bash
PROJECT         := inhealtcare
PHP_SVC         := php
NGINX_SVC       := nginx
APP_ROOT        := /var/www/html
HOST_PORT       := 9090
APP_URL         := http://localhost:$(HOST_PORT)

# Auto-deteksi `docker compose` (plugin v2+) vs `docker-compose` (standalone v1)
DC := $(shell if docker compose version >/dev/null 2>&1; \
                then echo "docker compose"; \
                else echo "docker-compose"; fi)

# Argumen opsional: make yiic CMD="migrate up"
CMD  ?=
ARGS ?=

# Warna output
C_RESET := \033[0m
C_BOLD  := \033[1m
C_CYAN  := \033[36m
C_GREEN := \033[32m
C_YELLOW:= \033[33m
C_RED   := \033[31m

.DEFAULT_GOAL := help

# ==============================================================================
#  Bantuan
# ==============================================================================

.PHONY: help
help: ## Tampilkan daftar perintah
	@printf "\n$(C_BOLD)$(PROJECT)$(C_RESET) - Docker Orchestration\n"
	@printf "  Compose CLI : $(C_CYAN)$(DC)$(C_RESET)\n"
	@printf "  URL Aplikasi: $(C_CYAN)$(APP_URL)$(C_RESET)\n\n"
	@printf "$(C_BOLD)PERINTAH:$(C_RESET)\n"
	@grep -hE '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) \
		| awk 'BEGIN {FS = ":.*?## "}; {printf "  $(C_CYAN)%-18s$(C_RESET) %s\n", $$1, $$2}'
	@printf "\n$(C_BOLD)CONTOH:$(C_RESET)\n"
	@printf "  make up                          # jalankan stack\n"
	@printf "  make logs SVC=php                # ikuti log service tertentu\n"
	@printf "  make yiic CMD=\"migrate up\"       # jalankan console command Yii\n"
	@printf "  make composer ARGS=\"require x/y\" # jalankan composer\n\n"

# ==============================================================================
#  Preflight
# ==============================================================================

.PHONY: check
check: ## Verifikasi Docker & file konfigurasi tersedia
	@command -v docker >/dev/null 2>&1 \
		|| { printf "$(C_RED)ERROR: docker tidak ditemukan di PATH$(C_RESET)\n"; exit 1; }
	@docker info >/dev/null 2>&1 \
		|| { printf "$(C_RED)ERROR: docker daemon tidak berjalan / tidak ada izin akses$(C_RESET)\n"; exit 1; }
	@for f in Dockerfile docker-compose.yml nginx.conf php-fpm.conf docker-entrypoint.sh; do \
		[ -f "$$f" ] || { printf "$(C_RED)ERROR: file $$f tidak ditemukan$(C_RESET)\n"; exit 1; }; \
	done
	@$(DC) config -q \
		|| { printf "$(C_RED)ERROR: docker-compose.yml tidak valid$(C_RESET)\n"; exit 1; }
	@printf "$(C_GREEN)OK$(C_RESET) - docker aktif, konfigurasi valid\n"

.PHONY: config
config: ## Tampilkan konfigurasi compose hasil resolve
	@$(DC) config

# ==============================================================================
#  Siklus hidup container
# ==============================================================================

.PHONY: build
build: check ## Build image PHP (pakai cache)
	@printf "$(C_BOLD)>> Build image$(C_RESET)\n"
	@$(DC) build

.PHONY: build-nc
build-nc: check ## Build image PHP tanpa cache
	@printf "$(C_BOLD)>> Build image (no-cache)$(C_RESET)\n"
	@$(DC) build --no-cache --pull

.PHONY: up
up: check ## Jalankan stack di background
	@printf "$(C_BOLD)>> Menjalankan stack$(C_RESET)\n"
	@$(DC) up -d --remove-orphans
	@$(MAKE) --no-print-directory ps
	@printf "\n$(C_GREEN)Aplikasi:$(C_RESET) $(APP_URL)\n"

.PHONY: up-fg
up-fg: check ## Jalankan stack di foreground (log langsung terlihat)
	@$(DC) up --remove-orphans

.PHONY: down
down: ## Hentikan & hapus container (volume TETAP aman)
	@printf "$(C_BOLD)>> Menghentikan stack$(C_RESET)\n"
	@$(DC) down --remove-orphans

.PHONY: stop
stop: ## Hentikan container tanpa menghapusnya
	@$(DC) stop

.PHONY: start
start: ## Jalankan kembali container yang dihentikan
	@$(DC) start

.PHONY: restart
restart: ## Restart semua container
	@$(DC) restart
	@$(MAKE) --no-print-directory ps

.PHONY: restart-php
restart-php: ## Restart service PHP saja (setelah ubah php-fpm.conf)
	@$(DC) restart $(PHP_SVC)

.PHONY: restart-nginx
restart-nginx: ## Restart service nginx saja (setelah ubah nginx.conf)
	@$(DC) restart $(NGINX_SVC)

.PHONY: rebuild
rebuild: ## Build ulang lalu jalankan stack (down -> build -> up)
	@$(MAKE) --no-print-directory down
	@$(MAKE) --no-print-directory build
	@$(MAKE) --no-print-directory up

# ==============================================================================
#  Observasi
# ==============================================================================

SVC ?=

.PHONY: ps
ps: ## Tampilkan status container
	@$(DC) ps

.PHONY: logs
logs: ## Ikuti log (pakai SVC=php atau SVC=nginx untuk memfilter)
	@$(DC) logs -f --tail=100 $(SVC)

.PHONY: logs-php
logs-php: ## Ikuti log service PHP
	@$(DC) logs -f --tail=100 $(PHP_SVC)

.PHONY: logs-nginx
logs-nginx: ## Ikuti log service nginx
	@$(DC) logs -f --tail=100 $(NGINX_SVC)

.PHONY: logs-app
logs-app: ## Ikuti log aplikasi Yii (protected/runtime/application.log)
	@$(DC) exec $(PHP_SVC) tail -f $(APP_ROOT)/protected/runtime/application.log

.PHONY: stats
stats: ## Pantau pemakaian CPU/memori container
	@docker stats $(PROJECT)-$(NGINX_SVC) $(PROJECT)-$(PHP_SVC)

.PHONY: health
health: ## Cek aplikasi merespons HTTP
	@printf ">> GET $(APP_URL) ... "
	@code=$$(curl -s -o /dev/null -w '%{http_code}' --max-time 15 $(APP_URL) || echo "000"); \
	if [ "$$code" = "000" ]; then \
		printf "$(C_RED)GAGAL (tidak ada respons)$(C_RESET)\n"; exit 1; \
	elif [ "$$code" -ge 500 ]; then \
		printf "$(C_RED)HTTP $$code$(C_RESET)\n"; exit 1; \
	else \
		printf "$(C_GREEN)HTTP $$code$(C_RESET)\n"; \
	fi

# ==============================================================================
#  Akses shell & perintah dalam container
# ==============================================================================

.PHONY: shell
shell: ## Buka shell di container PHP (user www-data)
	@$(DC) exec -u www-data $(PHP_SVC) sh

.PHONY: shell-root
shell-root: ## Buka shell di container PHP sebagai root
	@$(DC) exec -u root $(PHP_SVC) sh

.PHONY: shell-nginx
shell-nginx: ## Buka shell di container nginx
	@$(DC) exec $(NGINX_SVC) sh

.PHONY: yiic
yiic: ## Jalankan Yii console. Contoh: make yiic CMD="migrate up"
	@if [ -z '$(CMD)' ]; then \
		printf "$(C_RED)ERROR:$(C_RESET) wajib isi CMD. Contoh: make yiic CMD=\"migrate up\"\n"; \
		exit 1; \
	fi
	@$(DC) exec -u www-data $(PHP_SVC) sh -c 'cd $(APP_ROOT)/protected && php yiic.php $(CMD)'

.PHONY: cron
cron: ## Jalankan cron.php sekali secara manual
	@$(DC) exec -u www-data $(PHP_SVC) php $(APP_ROOT)/cron.php $(ARGS)

.PHONY: php
php: ## Jalankan perintah php arbitrer. Contoh: make php ARGS="-v"
	@$(DC) exec -u www-data $(PHP_SVC) php $(ARGS)

# ==============================================================================
#  Dependensi & kualitas kode
# ==============================================================================

.PHONY: composer
composer: ## Jalankan composer. Contoh: make composer ARGS="install"
	@$(DC) exec -u www-data $(PHP_SVC) composer $(ARGS)

.PHONY: composer-install
composer-install: ## composer install (produksi: tanpa dev, autoloader dioptimasi)
	@$(DC) exec -u www-data $(PHP_SVC) composer install --no-dev --optimize-autoloader

.PHONY: composer-dump
composer-dump: ## Regenerasi autoloader composer
	@$(DC) exec -u www-data $(PHP_SVC) composer dump-autoload --optimize

.PHONY: lint
lint: ## Cek sintaks PHP pada seluruh protected/ (php -l)
	@$(DC) exec -u www-data $(PHP_SVC) sh -c \
		'find $(APP_ROOT)/protected -name "*.php" -print0 \
		 | xargs -0 -n1 -P4 php -l 2>&1 | grep -v "^No syntax errors" || true'

.PHONY: phpcs
phpcs: ## Jalankan PHP_CodeSniffer. Contoh: make phpcs ARGS="protected/components"
	@$(DC) exec -u www-data $(PHP_SVC) ./bin/phpcs $(if $(ARGS),$(ARGS),protected/components)

# ==============================================================================
#  Pemeliharaan
# ==============================================================================

.PHONY: perms
perms: ## Perbaiki izin runtime, assets, uploads di dalam container
	@printf "$(C_BOLD)>> Memperbaiki izin$(C_RESET)\n"
	@$(DC) exec -u root $(PHP_SVC) sh -c \
		'for d in $(APP_ROOT)/protected/runtime $(APP_ROOT)/assets $(APP_ROOT)/uploads /var/lib/php/sessions; do \
			[ -d "$$d" ] && chown -R www-data:www-data "$$d" && chmod -R 775 "$$d" && echo "  fixed $$d"; \
		 done'

.PHONY: clear-assets
clear-assets: ## Kosongkan cache assets Yii (auto-regenerasi saat request berikutnya)
	@printf "$(C_YELLOW)Menghapus isi assets/ (akan dibuat ulang otomatis oleh Yii).$(C_RESET)\n"
	@read -p "Lanjutkan? [y/N] " ans; [ "$$ans" = "y" ] || { echo "Dibatalkan."; exit 1; }
	@$(DC) exec -u root $(PHP_SVC) sh -c 'rm -rf $(APP_ROOT)/assets/*'
	@$(MAKE) --no-print-directory perms
	@printf "$(C_GREEN)Assets dikosongkan.$(C_RESET)\n"

.PHONY: clear-runtime
clear-runtime: ## Kosongkan cache runtime Yii (log dipertahankan)
	@$(DC) exec -u root $(PHP_SVC) sh -c \
		'find $(APP_ROOT)/protected/runtime -type f ! -name "*.log*" -delete'
	@$(MAKE) --no-print-directory perms
	@printf "$(C_GREEN)Runtime cache dikosongkan (log tetap ada).$(C_RESET)\n"

# ==============================================================================
#  Operasi destruktif - semuanya meminta konfirmasi
# ==============================================================================

.PHONY: down-volumes
down-volumes: ## [DESTRUKTIF] Hentikan stack + hapus volume (semua sesi login hilang)
	@printf "$(C_RED)$(C_BOLD)PERINGATAN$(C_RESET)\n"
	@printf "  Perintah ini menghapus volume Docker:\n"
	@printf "    - php-sessions : SEMUA pengguna yang sedang login akan terlempar keluar\n"
	@printf "    - php-socket\n"
	@printf "  Kode sumber dan database TIDAK terpengaruh (database berada di server eksternal).\n\n"
	@read -p "Ketik 'hapus-volume' untuk melanjutkan: " ans; \
		[ "$$ans" = "hapus-volume" ] || { echo "Dibatalkan."; exit 1; }
	@$(DC) down -v --remove-orphans
	@printf "$(C_GREEN)Volume dihapus.$(C_RESET)\n"

.PHONY: clean
clean: ## [DESTRUKTIF] Hapus container + image milik project ini
	@printf "$(C_RED)$(C_BOLD)PERINGATAN$(C_RESET)\n"
	@printf "  Menghapus container dan image milik project '$(PROJECT)'.\n"
	@printf "  Build berikutnya harus mengunduh ulang seluruh layer.\n"
	@printf "  Volume TIDAK dihapus (gunakan 'make down-volumes' untuk itu).\n\n"
	@read -p "Ketik 'hapus-image' untuk melanjutkan: " ans; \
		[ "$$ans" = "hapus-image" ] || { echo "Dibatalkan."; exit 1; }
	@$(DC) down --rmi local --remove-orphans
	@printf "$(C_GREEN)Container dan image dihapus.$(C_RESET)\n"

# ==============================================================================
#  Alur kerja gabungan
# ==============================================================================

.PHONY: init
init: check build up perms ## Setup awal: build + jalankan + perbaiki izin
	@printf "\n$(C_GREEN)$(C_BOLD)Setup selesai.$(C_RESET) Buka $(APP_URL)\n"

.PHONY: deploy-local
deploy-local: ## Refresh penuh: rebuild + izin + cek kesehatan
	@$(MAKE) --no-print-directory down
	@$(MAKE) --no-print-directory build
	@$(MAKE) --no-print-directory up
	@$(MAKE) --no-print-directory perms
	@sleep 3
	@$(MAKE) --no-print-directory health
