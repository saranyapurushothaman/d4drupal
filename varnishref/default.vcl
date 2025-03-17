vcl 4.0;

# Define ACL for allowed purge IPs
acl purge_allowed {
    "drupalcontainer";  # Allow purges from localhost
    "172.27.0.3";  # Example: Replace with your server IP or trusted IPs
}

backend default {
    .host = "drupalcontainer";  # Replace with your backend server hostname or IP.
    .port = "80";                 # Replace with the backend port if needed.
}

sub vcl_backend_response {
    // Remove headers that prevent caching.
    unset beresp.http.Cache-Control;
    unset beresp.http.X-Drupal-Cache;

    // Force caching: set a TTL of 120 seconds and a grace period of 30 seconds.
    set beresp.ttl = 120s;
    set beresp.grace = 30s;
}


sub vcl_recv {
    if (req.method == "PURGE" || req.method == "BAN") {
        if (client.ip ~ purge_allowed) {
            // Call the ban() function with a ban rule.
            ban("req.url ~ " + req.url);
            // Return a 200 response indicating a successful purge.
            return (synth(200, "Purged"));
        } else {
            return (synth(405, "Not allowed."));
        }
    }
    # Pass requests to the backend if not a GET.
    if (req.method != "GET" && req.method != "HEAD") {
        return (pass);
    }
}

sub vcl_deliver {
    // Add a header to indicate cache status.
    if (obj.hits > 0) {
        set resp.http.X-Cache = "HIT";
    } else {
        set resp.http.X-Cache = "MISS";
    }
}
