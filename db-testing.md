# ETS Testing Database

# Start the testing database
docker-compose -f docker-compose.test-db.yml up -d

# Check if it's running
docker ps

## **Database Connection**
### From MySQL Workbench
1. **Open MySQL Workbench**
2. **Click "+" to create new connection**
3. **Enter connection details**:
   - **Connection Name**: `ETS Testing Database`
   - **Connection Method**: `Standard (TCP/IP)`
   - **Hostname**: `localhost`
   - **Port**: `3307`
   - **Username**: `ets_evaluate_user_test`
   - **Password**: Click "Store in Vault" and enter `tZxHFizMpxll5nA`
   - **Default Schema**: `ets_evaluate_db_test`
4. **Click "Test Connection"** to verify
5. **Click "OK"** to save the connection
6. **Double-click the connection** to open

php artisan migrate --seed