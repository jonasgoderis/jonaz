set :application, "development"
set :branch, "#{application}"

# define roles
set :user, "fill_in_staging_user"
# For our projects, this will be gallium most of the times.
server "dev.wijsproject.be", :app, :web, :db, :primary => true

set :deploy_to, "/home/#{user}/apps/#{application}"
set :document_root, "/home/#{user}/default_www"

set :composer_bin, "#{shared_path}/composer.phar"
set :use_composer, true
