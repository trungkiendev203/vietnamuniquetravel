import urllib.request
import urllib.parse
import re

# 1. GET /admin/login
req = urllib.request.Request('http://127.0.0.1:8000/admin/login')
with urllib.request.urlopen(req) as resp:
    html = resp.read().decode('utf-8')
    cookie = resp.headers.get('Set-Cookie')

csrf_match = re.search(r'name="_csrf" value="([^"]+)"', html)
csrf_token = csrf_match.group(1) if csrf_match else ''
print('Extracted Admin CSRF token:', csrf_token)

# 2. Login POST
login_data = urllib.parse.urlencode({
    '_csrf': csrf_token,
    'username': 'admin',
    'password': 'Admin@2026!VNU'
}).encode('utf-8')

login_req = urllib.request.Request('http://127.0.0.1:8000/admin/login', data=login_data, headers={'Cookie': cookie})
with urllib.request.urlopen(login_req) as login_resp:
    print('Dashboard URL after login:', login_resp.geturl())
    dash_html = login_resp.read().decode('utf-8')
    if 'Dashboard Overview' in dash_html:
        print('SUCCESS: Logged into Admin Dashboard!')

# 3. GET /admin/bookings
bookings_req = urllib.request.Request('http://127.0.0.1:8000/admin/bookings', headers={'Cookie': cookie})
with urllib.request.urlopen(bookings_req) as bookings_resp:
    b_html = bookings_resp.read().decode('utf-8')
    if 'VNU-2026' in b_html:
        print('SUCCESS: Found booking in Admin Bookings List!')
