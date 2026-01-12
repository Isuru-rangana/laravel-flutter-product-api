class ApiConstants {
  // Laravel API Base URL - For Android emulator, use 10.0.2.2 instead of localhost
  static const String baseUrl = 'http://10.0.2.2:8000';
  
  // API Endpoints
  static const String categoriesEndpoint = '/api/categories';
  static const String productsEndpoint = '/api/products';
  
  // HTTP Headers
  static const Map<String, String> jsonHeaders = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  };
  
  // Timeouts
  static const Duration requestTimeout = Duration(seconds: 30);
  static const Duration connectionTimeout = Duration(seconds: 10);
}