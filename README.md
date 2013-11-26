PyroCMS-SmushIT
===============

## What is SmushIT?

Developed by Yahoo, SmushIt uses optimization techniques specific to image format to remove unnecessary bytes from image files.  
It is a "**lossless**" tool, which means it optimizes the images without changing their look or visual quality.

## What do you need?

Your server, or hosting, must have 

1. cURL
2. json

enabled.

## How to install?

Simply download or clone the repo and make sure that the folder is named "**smushit**" without quotes.  
Copy and paste the folder in your **addons** or **shared_addons** folder and install it via Control Panel.  
This module do not have a backend or frontend view, it just have a setting in the Settings module of your site.  
By default smushit will run for every images uploaded via Files module, if you do not want it to run automatically go in Settings and disable it.

## How it works?

This module will hook to the Files module just after the image upload using **file_uploaded** event.  
The event will check if the uploaded file is a valid image checking its extension and if it is in the allowed extension the module will send the image to smushit.com and then download the smushd one if the size is smaller.  
**NB:** Module doesn't work on localhost just because it will send to smushit the file url not the real image, so smushit is not able to get images from your computer.