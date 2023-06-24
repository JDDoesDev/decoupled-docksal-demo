FROM docksal/cli:php8.1-3.2

# Include headless chrome for BLT Behat testing.
RUN apt-get update \
    && apt-get -y --no-install-recommends install chromium chromium-driver \
    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

USER docker

# Aliases...
RUN echo 'alias ll="ls -lha"' >> ~/.bashrc

SHELL ["/bin/bash", "-c"]

RUN set -e; \
    # Initialize the user environment (this loads nvm)
    source $HOME/.profile; \
    # Install the necessary nodejs version
    nvm install 18.16.1; \
    nvm alias default 18.16.1; \
    nvm use default; \
    # Install packages
    npm install -g npm@9.7.2; \
    npm install -g gatsby-cli; \
    # Cleanup
    nvm clear-cache && npm cache clear --force; \
    # Fix npm complaining about permissions and not being able to update
    sudo rm -rf $HOME/.config;

USER root

EXPOSE 8000
