build:
	docker build --platform=linux/amd64 -t opensuse-lounge:dev -f Containerfile .

test:
	docker compose -f compose.yaml -f compose.test.yaml up
