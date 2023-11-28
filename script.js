// Initialize the map with the marker variable declared
let map;
let mapMarker;

function initMap() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                map = new google.maps.Map(document.getElementById("map"), {
                    center: userLocation,
                    zoom: 20,
                });

                // Create the marker here
                mapMarker = new google.maps.Marker({ position: userLocation, map });
            },
            (error) => {
                console.error('Geolocation Error:', error);
            },
            { enableHighAccuracy: true } // Enable high accuracy
        );
    } else {
        alert("Geolocation is not supported by your browser.");
    }
}

function watchLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(
            (position) => {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                // Update the marker's position
                mapMarker.setPosition({ lat: latitude, lng: longitude });

                // Send the location data to the server using AJAX
                const user_id = 1; // You can identify the user somehow
                const data = { latitude, longitude, user_id };
                console.log(latitude);
                console.log(longitude);
                fetch('update-location.php', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                    .catch((error) => {
                        console.error('Fetch Error:', error);
                    });
            },
            (error) => {
                console.error('Geolocation Error:', error);
            },
            { enableHighAccuracy: true } // Enable high accuracy
        );

        // Set interval to update location every 1 minute (60000 milliseconds)
        setInterval(() => {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    // Update the marker's position
                    mapMarker.setPosition({ lat: latitude, lng: longitude });

                    // Send the location data to the server using AJAX
                    const user_id = 1; // You can identify the user somehow
                    const data = { latitude, longitude, user_id };
                    console.log(latitude);
                    console.log(longitude);
                    fetch('update-location.php', {
                        method: 'POST',
                        body: JSON.stringify(data),
                        headers: {
                            'Content-Type': 'application/json',
                        },
                    })
                        .catch((error) => {
                            console.error('Fetch Error:', error);
                        });
                },
                (error) => {
                    console.error('Geolocation Error:', error);
                },
                { enableHighAccuracy: true } // Enable high accuracy
            );
        }, 60000); // 60000 milliseconds = 1 minute
    } else {
        alert("Geolocation is not supported by your browser.");
    }
}

// Initialize the map and start watching the user's location
initMap();
watchLocation();
