import urllib.request
import urllib.parse
import re

# 1. GET /booking to obtain CSRF token and cookie
req = urllib.request.Request('http://127.0.0.1:8000/booking')
with urllib.request.urlopen(req) as resp:
    html = resp.read().decode('utf-8')
    cookie = resp.headers.get('Set-Cookie')

csrf_match = re.search(r'name="_csrf" value="([^"]+)"', html)
csrf_token = csrf_match.group(1) if csrf_match else ''
print('Extracted CSRF token:', csrf_token)

# 2. Submit booking form via POST
post_data = urllib.parse.urlencode({
    '_csrf': csrf_token,
    'website_hp': '',
    'tour_name': '[PLHDT-01] PLHDT - 01: BIKE TOURS: Hidden Villages & Hieu Waterfall Adventure',
    'tour_id': '1',
    'travel_date': '2026-09-15',
    'adults': '2',
    'children': '1',
    'pickup_location': 'Pu Luong Mist Valley Home',
    'dietary_requirements': 'Vegetarian',
    'health_notes': 'None',
    'special_requests': 'Please arrange twin beds.',
    'fullname': 'John Doe Test Traveler',
    'nationality': 'France',
    'email': 'johndoe.test@example.com',
    'phone_whatsapp': '+33612345678',
    'agree_policy': '1'
}).encode('utf-8')

post_req = urllib.request.Request('http://127.0.0.1:8000/booking/submit', data=post_data, headers={'Cookie': cookie})
with urllib.request.urlopen(post_req) as post_resp:
    final_url = post_resp.geturl()
    final_html = post_resp.read().decode('utf-8')
    print('Final Redirect URL:', final_url)
    print('Booking Success Page Status:', post_resp.status)
    if 'VNU-2026' in final_html:
        print('SUCCESS: Booking code found in output!')
