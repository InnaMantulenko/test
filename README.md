<h1 align="center">Search Data Form</h1>

## Deployment

<ol type="1">
<li> 
Copy code:
<code>git clone https://github.com/InnaMantulenko/test.git</code>
</li>

<li>
Set Up Environment Variables: Copy the .env.example file to .env 
<code>cp .env.example .env</code>
</li>

<li>
Install the project's dependencies using Composer:
<code>composer install</code>
</li>

<li>
Set your environment-specific configuration, such as database settings and application keys:
<code>php artisan key:generate</code>
</li>

<li>
Run Database Migrations and Seeders:
<code>
php artisan migrate --seed
</code>
</li>

<li>
Make sure the appropriate directories are writable by the web server user:

<code>
chmod -R 775 storage bootstrap/cache
</code>
<code>
chown -R www-data:www-data storage bootstrap/cache
</code>
</li>

<li>
Install npm:
<code>npm i</code>
<code>npm run dev</code>
</li>

</ol>

<b>Important:</b>
<p>
If you have Elasticsearch installed, you can switch to it by changing the configuration in the .env file:
<code>ELASTICSEARCH_ENABLED=true</code>
Don't forget to specify your ES host:
<code>ELASTICSEARCH_HOSTS="localhost:9200"</code>
</p>
