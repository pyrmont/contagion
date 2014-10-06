require 'sinatra'
require 'sequel'

# Set the configuration options.
database_file = 'database.sqlite'

# Retrieve information from the database.
store = Sequel.sqlite database_file
players = store[:players]

# Enable sessions.
enable :sessions

# Set the index route.
get '/' do
    @message = session[:message]
    session[:message] = ''
    erb :index
end

# Set the submission route.
post '/submit' do
    player = players.where(:number => params[:player_id])

    if player.count == 1 && player.first[:status] == 'survivor'
        player.update(:status => 'zombie')
        session[:message] = :infected
    elsif player.count == 1 && player.first[:status] == 'zombie'
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

# Set the super secret route for a listing of all players.
get '/list' do
    @players = players.all
    erb :list
end