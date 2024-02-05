SHELL = /bin/bash

dev-up:
	docker compose -f docker-compose.dev.yml up -d

dev-down:
	docker compose -f docker-compose.dev.yml down

dev-shutdown:
	docker compose -f docker-compose.dev.yml down -v

dev-app-bash:
	docker compose -f docker-compose.dev.yml exec app bash

prod-up:
	docker compose -f docker-compose.prod.yml up -d

prod-down:
	docker compose -f docker-compose.prod.yml down

prod-shutdown:
	docker compose -f docker-compose.prod.yml down -v

prod-app-bash:
	docker compose -f docker-compose.prod.yml exec app bash