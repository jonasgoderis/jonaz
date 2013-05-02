set :application, "production"
set :branch, "#{application}"

# define roles
set :user, "user"
# For our projects, this will be gallium most of the times.
server "server", :app, :web, :db, :primary => true

set :deploy_to, "/home/#{user}/apps/#{application}"
set :document_root, "/home/#{user}/default_www"

set :composer_bin, "#{shared_path}/composer.phar"
set :use_composer, true
