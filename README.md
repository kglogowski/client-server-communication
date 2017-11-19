Unfinished, tmp version!!
=========================

Installation
------------

1. Run command: composer require user/package_name "version"

2. Configure your config.yml
```
    fos_rest:
       routing_loader:
           default_format: json
           include_format: true
       param_fetcher_listener: force
       body_listener: true
       allowed_methods_listener: true
       view:
           view_response_listener: 'force'
           formats:
               json: true
       exception:
           enabled: true
           exception_controller: 'csc.controller.rest_exception:showAction'
       format_listener:
           rules:
               - { path: '^/', priorities: ['json'], fallback_format: json, prefer_extension: false }
       service:
           view_handler: fos_rest.view_handler.default
```