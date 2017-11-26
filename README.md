Unfinished, not to use!!
=======

Installation
------------

1. Run command: ``composer require kglogowski/client-server-communication "@dev"``

2. Add to Kernel:
    ```
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
5. Configure security.yml:
    ```
    #Example
    security:
        encoders:
            AppBundle\Entity\User:
                id: csc.rest.security.encoder.password
    
        providers:
            user_token:
                entity:
                    class: AppBundle:User\User
                    property: login
            user:
                id: app.rest.security.provider.token_user
        firewalls:
            dev:
                pattern: ^/(_(profiler|wdt)|css|images|js)/
                security: false
    
            user_token:
                pattern: ^/v1/auth/token$
                provider: user_token
                guard:
                    authenticators:
                        - app.rest.security.authenticator.credential
            user:
                pattern: ^/v1(/|/auth/token/clear$)
                provider: user
                guard:
                    authenticators:
                        - app.rest.security.authenticator.token
                        - app.rest.security.authenticator.sso
                    entry_point: app.rest.security.authenticator.token
            main:
                pattern: ^/
                anonymous: ~
    ```

6. Authenticators
    ```php
    //Example authenticators:
    class RestCredentialAuthenticator extends BaseAuthenticator
    {
        public function getAccessTokenClass(): string
        {
            return UserAccessToken::class;
        }
    }
    
    class TokenAuthenticator extends BaseAuthenticator
    {
        /**
         * @return string
         */
        public function getAccessTokenClass(): string
        {
            return UserAccessToken::class;
        }
    }
    ```
7. Provider