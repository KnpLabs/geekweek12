# Capifony documentation: http://capifony.org
# Capistrano documentation: https://github.com/capistrano/capistrano/wiki

# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL

set :application, "set your application name here"
set :domain,      "#{application}.com"
set :deploy_to,   "/var/www/#{domain}"
set :app_path,    "app"

role :web,        domain
role :app,        domain
role :db,         domain, :primary => true

set :scm,         :git
set :repository,  "git@github.com:KnpLabs/#{application}.git"
set :branch,      "master"
set :deploy_via,  :remote_cache

ssh_options[:forward_agent] = true

set :use_composer,   true
set :update_vendors, true

set :writable_dirs,     ["app/cache", "app/logs"]
set :webserver_user,    "www-data"
set :permission_method, :acl

set :shared_files,    ["app/config/parameters.yml", "web/.htaccess", "web/robots.txt"]
set :shared_children, ["app/logs", "web/uploads", "web/assets"]

set :model_manager, "doctrine"

set :keep_releases, 3
after "deploy:update", "deploy:cleanup"
