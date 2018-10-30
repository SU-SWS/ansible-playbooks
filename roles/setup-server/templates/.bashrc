alias ll='ls -alhF'

# Environment variables are different to drush than when signed in.
WEBHEAD=$(hostname | cut -d'.' -f 1);
export WEBHEAD
CACHE_PREFIX=$HOME/.drush/$WEBHEAD
export CACHE_PREFIX
