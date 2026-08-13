import urllib.request
import urllib.parse
import re

BASE_URL = 'http://127.0.0.1:8000'

def make_request(url, data=None, headers=None, method=None):
    if headers is None:
        headers = {}
    req = urllib.request.Request(url, data=data, headers=headers, method=method)
    try:
        resp = urllib.request.urlopen(req)
        body = resp.read().decode('utf-8')
        set_cookie = resp.headers.get('Set-Cookie')
        return resp.status, resp.geturl(), body, set_cookie
    except urllib.error.HTTPError as e:
        body = e.read().decode('utf-8') if e.fp else ''
        return e.code, e.geturl(), body, e.headers.get('Set-Cookie')

def extract_csrf(html):
    match = re.search(r'name="_csrf" value="([^"]+)"', html)
    return match.group(1) if match else ''

print("=== STARTING COMPREHENSIVE TEST SUITE ===")

# Test 1: Admin Auth Security Check (Unauthorized access to /admin/tours)
status, url, body, _ = make_request(f"{BASE_URL}/admin/tours")
assert '/admin/login' in url, "SECURITY ERROR: Admin area allowed unauthenticated access!"
print("PASS: Test 1: Unauthenticated request to /admin/tours correctly redirected to /admin/login")

# Test 2: Admin Login
status, url, html, cookie = make_request(f"{BASE_URL}/admin/login")
csrf_token = extract_csrf(html)
login_data = urllib.parse.urlencode({
    '_csrf': csrf_token,
    'username': 'admin',
    'password': 'Admin@2026!VNU'
}).encode('utf-8')
status, url, dash_html, cookie_header = make_request(f"{BASE_URL}/admin/login", data=login_data, headers={'Cookie': cookie})
admin_cookie = cookie_header if cookie_header else cookie
assert 'Dashboard Overview' in dash_html, "LOGIN ERROR: Failed to log in as admin"
print("PASS: Test 2: Admin logged in successfully")

# Test 3: Add New Tour via Admin
status, url, form_html, _ = make_request(f"{BASE_URL}/admin/tours/create", headers={'Cookie': admin_cookie})
admin_csrf = extract_csrf(form_html)
new_tour_data = urllib.parse.urlencode({
    '_csrf': admin_csrf,
    'code': 'VNU-TEST-99',
    'slug': 'test-automated-tour',
    'status': '1',
    'duration_type': 'fullday',
    'duration_days': '2',
    'difficulty': 'medium',
    'transportation': 'Motorbike',
    'group_size': 'Private',
    'price_from_usd': '150.00',
    'price_from_vnd': '3750000',
    'is_featured': '1',
    'is_signature': '0',
    'title_en': 'Automated Test Tour EN',
    'short_description_en': 'Short test description',
    'highlights_en': 'Highlight 1\nHighlight 2',
    'overview_en': 'Overview test text',
    'inclusions_en': 'Includes breakfast',
    'exclusions_en': 'Excludes tips',
    'title_vi': 'Tour Kiem Thu Tu Dong VI'
}).encode('utf-8')

status, url, save_resp, _ = make_request(f"{BASE_URL}/admin/tours/save", data=new_tour_data, headers={'Cookie': admin_cookie})
assert 'Tour created successfully' in save_resp or 'edit' in url, "TOUR ERROR: Failed to create tour"
print("PASS: Test 3: Tour VNU-TEST-99 created successfully")

# Test 4: Submit Booking & Verify Admin Notification
status, url, b_form_html, b_cookie = make_request(f"{BASE_URL}/booking")
b_csrf = extract_csrf(b_form_html)

status, url, t_html, _ = make_request(f"{BASE_URL}/tours/test-automated-tour")
match_tid = re.search(r'name="tour_id" value="(\d+)"', t_html)
tour_id = match_tid.group(1) if match_tid else '1'

booking_post = urllib.parse.urlencode({
    '_csrf': b_csrf,
    'website_hp': '',
    'tour_id': tour_id,
    'tour_name': 'Automated Test Tour EN',
    'travel_date': '2026-10-20',
    'adults': '2',
    'children': '0',
    'pickup_location': 'Hanoi Old Quarter Hotel',
    'fullname': 'Automated Tester',
    'nationality': 'USA',
    'email': 'tester@example.com',
    'phone_whatsapp': '+123456789',
    'agree_policy': '1'
}).encode('utf-8')

status, url, b_succ_html, _ = make_request(f"{BASE_URL}/booking/submit", data=booking_post, headers={'Cookie': b_cookie})
b_code_match = re.search(r'VNU-\d+-[A-Z0-9]+', b_succ_html)
assert b_code_match, "BOOKING ERROR: Booking submission failed"
booking_code = b_code_match.group(0)
print(f"PASS: Test 4: Booking created with code {booking_code}")

status, url, notif_html, _ = make_request(f"{BASE_URL}/admin/notifications", headers={'Cookie': admin_cookie})
assert booking_code in notif_html, "NOTIFICATION ERROR: Booking notification not found in admin"
print(f"PASS: Test 4: Admin notification received for booking {booking_code}")

# Test 5: Submit Public Review & Moderate
status, url, t_detail_html, r_cookie = make_request(f"{BASE_URL}/tours/test-automated-tour")
r_csrf = extract_csrf(t_detail_html)

review_post = urllib.parse.urlencode({
    '_csrf': r_csrf,
    'website_hp': '',
    'client_name': 'Jane Reviewer',
    'email': 'tester@example.com',
    'booking_code': booking_code,
    'rating': '5',
    'content': 'This was an absolutely wonderful and authentic tour experience!'
}).encode('utf-8')

status, url, r_resp_html, _ = make_request(f"{BASE_URL}/tours/test-automated-tour/review", data=review_post, headers={'Cookie': r_cookie})
assert 'pending moderation' in r_resp_html, "REVIEW ERROR: Review submission message missing"
print("PASS: Test 5: Review submitted publicly, marked as pending")

status, url, pub_detail_html, _ = make_request(f"{BASE_URL}/tours/test-automated-tour")
assert 'This was an absolutely wonderful and authentic tour experience!' not in pub_detail_html, "SECURITY ERROR: Pending review exposed on public page!"
print("PASS: Test 5: Pending review correctly hidden from public page")

status, url, rev_admin_html, _ = make_request(f"{BASE_URL}/admin/reviews?status=pending", headers={'Cookie': admin_cookie})
assert 'Jane Reviewer' in rev_admin_html, "REVIEW ADMIN ERROR: Pending review not listed in admin"

rid_match = re.search(r'/admin/reviews/(\d+)/status', rev_admin_html)
assert rid_match, "REVIEW ADMIN ERROR: Review action button not found"
review_id = rid_match.group(1)

appr_post = urllib.parse.urlencode({
    '_csrf': admin_csrf,
    'status': 'approved'
}).encode('utf-8')
status, url, appr_resp, _ = make_request(f"{BASE_URL}/admin/reviews/{review_id}/status", data=appr_post, headers={'Cookie': admin_cookie})

status, url, pub_detail_approved_html, _ = make_request(f"{BASE_URL}/tours/test-automated-tour")
assert 'This was an absolutely wonderful and authentic tour experience!' in pub_detail_approved_html, "REVIEW ERROR: Approved review not showing publicly!"
print("PASS: Test 5: Review approved by admin and now visible publicly")

# Test 6: Toggle Status / Hide Tour & Test Soft Delete
toggle_post = urllib.parse.urlencode({'_csrf': admin_csrf}).encode('utf-8')
status, url, _, _ = make_request(f"{BASE_URL}/admin/tours/{tour_id}/toggle-status", data=toggle_post, headers={'Cookie': admin_cookie})

status, url, admin_tours_html, _ = make_request(f"{BASE_URL}/admin/tours?status=all", headers={'Cookie': admin_cookie})
assert 'VNU-TEST-99' in admin_tours_html, "ADMIN TOUR ERROR: Hidden tour disappeared from admin list!"

status, url, pub_tours_html, _ = make_request(f"{BASE_URL}/tours")
assert 'test-automated-tour' not in pub_tours_html, "PUBLIC TOUR ERROR: Hidden tour visible on public list!"
print("PASS: Test 6: Tour hidden status toggle verified (visible in admin, hidden in public)")

del_post = urllib.parse.urlencode({'_csrf': admin_csrf}).encode('utf-8')
status, url, del_resp, _ = make_request(f"{BASE_URL}/admin/tours/{tour_id}/delete", data=del_post, headers={'Cookie': admin_cookie})
assert 'archived' in del_resp or 'success' in del_resp, "DELETE ERROR: Soft delete/archiving failed"
print("PASS: Test 6: Safe delete/archive succeeded for tour with existing bookings/reviews")

print("\n=== ALL INTEGRATION TESTS PASSED SUCCESSFULLY! ===")
