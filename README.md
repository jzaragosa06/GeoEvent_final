# Geoevent 🌍

**Geoevent** is a web application designed to monitor and visualize natural disasters and atmospheric phenomena across the globe. Built using the Laravel PHP framework, it leverages Google Maps to provide an interactive experience, allowing users to track and receive real-time updates on various environmental conditions and events.

## Features

1. **Interactive Global Disaster Map**
   - Displays real-time natural disasters across the world on an interactive Google Maps interface.
   - Disasters shown include events such as earthquakes, hurricanes, floods, and wildfires.

2. **Location Monitoring and Alert Radius**
   - Users can select specific locations and define a radius to monitor for nearby natural disasters.
   - Receive notifications for any disaster activity within the set radius.

3. **Impact Assessment on Major Cities**
   - Identifies and highlights major cities potentially affected by natural disasters.
   - Useful for understanding the impact scope and preparing response strategies.

4. **Atmospheric Phenomena Visualization**
   - Provides current atmospheric data overlaid on Google Maps, including:
      - **Cloud Cover**: Visualizes cloud density in selected regions.
      - **Precipitation**: Shows areas with rain or snow for better situational awareness.
      - **Pressure**: Maps barometric pressure variations, useful for understanding weather fronts.
      - **Wind Speed**: Displays wind patterns and intensities.
      - **Temperature**: Monitors temperature changes across different regions.

5. **User Account Management**
   - **Registration and Login**: Allows users to create accounts to personalize their monitoring preferences.
   - **Logout**: Secure logout functionality to protect user data.

## Installation and Setup

To set up Geoevent locally, follow these steps:

1. **Clone the repository**:
   ```bash
    https://github.com/jzaragosa06/geoevent-web-app.git
    cd geoevent

2. **Install dependencies**:
   ```bash
    composer install
    npm install

3. **Run**:
   ```bash
    php artisan serve
    npm run dev


