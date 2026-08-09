import os
import zipfile

zip_filename = 'deploy-hosting.zip'
exclude_files = {
    'deploy-hosting.zip',
    'admin_hash.txt',
    'create_seed.py',
    'create_deploy_zip.py',
    'test_booking.py',
    'test_admin.py',
    'vnu_doc.txt',
    'pu_luong_doc.txt',
    'Thông tin tạo Website - VNU.docx',
    'PU LUONG TOUR – PLT.docx',
    '.env'  # User will configure .env from .env.example
}

exclude_dirs = {
    '.git',
    'extracted_assets',
    'storage/cache',
    'storage/database.sqlite'
}

count = 0
with zipfile.ZipFile(zip_filename, 'w', zipfile.ZIP_DEFLATED) as zipf:
    for root, dirs, files in os.walk('.'):
        dirs[:] = [d for d in dirs if os.path.normpath(os.path.join(root, d)) not in exclude_dirs and d not in ('.git', 'extracted_assets')]
        
        for file in files:
            file_path = os.path.normpath(os.path.join(root, file))
            
            if file in exclude_files or file.endswith('.sqlite') or file.endswith('.docx'):
                continue
            if 'storage/cache' in file_path or 'storage\\cache' in file_path:
                continue

            arcname = file_path
            zipf.write(file_path, arcname)
            count += 1

print(f"deploy-hosting.zip created successfully with {count} files! Size: {os.path.getsize(zip_filename) / (1024*1024):.2f} MB")
