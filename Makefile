SHELL = /bin/bash

dev-up:
	docker compose -f docker-compose.dev.yml up -d

dev-down:
	docker compose -f docker-compose.dev.yml down

dev-shutdown:
	docker compose -f docker-compose.dev.yml down -v

dev-app-bash:
	docker compose -f docker-compose.dev.yml exec app bash