FROM mysql:5.7.25

# set maintainer.
MAINTAINER Aleksandar Rakić <info@aleksandarrakic.com>

# Add the content of the database/ directory to your image
# All scripts in docker-entrypoint-initdb.d/ are automatically
# executed during container startup
COPY ./src/database/ /docker-entrypoint-initdb.d/

# install linux packages.
RUN apt-get update
RUN apt-get install

# make port 3306 available to the world outside this container.
EXPOSE 3306