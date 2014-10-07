require 'sinatra'
require 'sequel'

# Set the configuration options.
database_file = 'database.sqlite'
survivor_status = 'survivor'
zombie_status = 'zombie'

# Set options for Sinatra.
configure do
  set :static_cache_control, [:public, max_age: 60 * 60 * 24 * 365]
end

# Retrieve information from the database.
store = Sequel.sqlite database_file
players = store[:players]

# Enable sessions.
enable :sessions

# Set the index route.
get '/' do
    @num_survivors = players.where(:status => survivor_status).count
    @num_zombies = players.where(:status => zombie_status).count
    @message = session[:message]
    session[:message] = ''
    erb :index
end

# Set the submission route.
post '/submit' do
    player = players.where(:number => params[:player_id])

    if player.count == 1 && player.first[:status] == survivor_status
        player.update(:status => zombie_status)
        session[:message] = :infected
    elsif player.count == 1 && player.first[:status] == zombie_status
        session[:message] = :already
    elsif player.count == 0
        session[:message] = :invalid
    else
        redirect to('/error')
    end

    redirect to('/')
end

# Set the route for an error.
get '/error' do
    'Not sure what went wrong there.'
end

# Set the route for login.
get '/login' do
    @message = session[:message]
    session[:message] = ''
    erb :login
end

# Set the route for processing a login request.
post '/login' do
    keys = File.read('authentication').split(' ')
    if params[:password] == keys[0]
        session[:token] = keys[1]
        redirect to('/list')
    else
        session[:message] = :failed
        redirect to('/login')
    end
end

# Set the super secret route for a listing of all players.
get '/list' do
    keys = File.read('authentication').split(' ')
    redirect to('/login') unless session[:token] == keys[1]

    @num_survivors = players.where(:status => survivor_status).count
    @num_zombies = players.where(:status => zombie_status).count
    @players = players.all
    erb :list
end