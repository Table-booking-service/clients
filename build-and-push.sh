#!/bin/bash

#sudo docker login -u markrabushev
sudo docker compose build
sudo docker tag clients-app markrabushev/clients
sudo docker push markrabushev/clients
