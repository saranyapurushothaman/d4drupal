vcl 4.0;

backend default {
    .host = "drupalcontainer";  # Replace with your backend server hostname or IP.
    .port = "80";                 # Replace with the backend port if needed.
}

sub vcl_backend_response {
    // Force caching: set a TTL of 120 seconds and a grace period of 30 seconds.
    set beresp.ttl = 120s;
    set beresp.grace = 30s;
}

