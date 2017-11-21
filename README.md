Unfinished, not to use!!
=======

Installation
------------

1. Run command: composer require kglogowski/client-server-communication "@dev"

2. Add to Kernel:
```php
        $bundles = [
            ...
            new CSC\CSCBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new FOS\RestBundle\FOSRestBundle(),
        ];
```

3. Add configuration for simple and pager data object checkers:
```
#example
csc:
  simple_data_object:
      AppBundle\DataObject\TestSimpleDataObject:
          insertable_fields:
              - name
              - description
          updatable_fields:
              - name
              - description
  pager_data_object:
      AppBundle\DataObject\TestPagerDataObject:
          methods:
              getTracesList:
                  filter:
                      - id
                  sort:
                      - id
  
```
4. Configure your config.yml
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
           exception_controller: 'csc.rest.controller.exception:showAction'
       format_listener:
           rules:
               - { path: '^/', priorities: ['json'], fallback_format: json, prefer_extension: false }
       service:
           view_handler: fos_rest.view_handler.default
```