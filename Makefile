
tool=docker-compose run --rm tools

pull:
	@docker-compose pull

install:
	@$(tool) bash -ci '/fixright && sudo -E -u phpuser composer install'

prepare-update:
	@$(tool) bash -ci '/fixright && sudo -E -u phpuser composer update --dry-run'

