SHELL = /bin/bash

up:
	docker compose up -d

down:
	docker compose down

shutdown:
	docker compose down -v

app-bash:
	docker compose exec app bash