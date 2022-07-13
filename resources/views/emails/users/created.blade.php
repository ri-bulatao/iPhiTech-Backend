<div>
    <p>Hi {{ $user->first_name }},</p>
    <p>Welcome to iPhiTech, here are your credentials for the employee portal</p>
    
    <p>Email: {{ $user->email }}</p>
    <p>Password: {{ $password }}</p>

    <a href="{{ env('APP_URL') . '/login' }}">Login Here</a>
</div>