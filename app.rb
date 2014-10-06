require 'sinatra'
require 'sequel'

# Set the configuration options.
database_file = 'database.sqlite'

# Retrieve information from the database.
store = Sequel.sqlite database_file
players = store[:players]

# Set the index route.
get '/' do
    erb :index
end

# Set the submission route.
post '/submit' do
    player = players.where(:number => params[:player_id])

    if player.count == 1
        redirect to('/success')
    elsif player.count == 0
        redirect to('/failure')
    else
        redirect to('/error')
    end

    redirect to('/error') # It should be impossible to be here.
end

# Set the route for a successful update to the database.
get '/success' do
    'Success!'
end

# Set the route for a failed update to the database.
get '/failure' do
    'Failure!'
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