import 'dart:convert';
import 'package:http/http.dart' as http;
import '../models/category.dart';
import '../models/product.dart';
import '../utils/constants.dart';

class ApiService {
  static const String baseUrl = ApiConstants.baseUrl;

  Future<List<Category>> fetchCategories() async {
    try {
      print('Fetching categories from: $baseUrl/api/categories');
      
      final response = await http.get(
        Uri.parse('$baseUrl/api/categories'),
        headers: {'Accept': 'application/json'},
      ).timeout(Duration(seconds: 10));

      print('Response status: ${response.statusCode}');
      print('Response body: ${response.body}');

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        
        if (data['success'] == true && data['data'] != null) {
          final List<dynamic> categoriesJson = data['data'];
          final categories = categoriesJson.map((json) => Category.fromJson(json)).toList();
          print('Successfully parsed ${categories.length} categories');
          return categories;
        } else {
          throw Exception('Failed to load categories: ${data['message']}');
        }
      } else {
        throw Exception('Failed to load categories: HTTP ${response.statusCode}');
      }
    } catch (e) {
      print('Error fetching categories: $e');
      throw Exception('Network error: $e');
    }
  }

  Future<bool> saveProduct(Product product) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/api/products'),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: json.encode(product.toJson()),
      );

      if (response.statusCode == 200 || response.statusCode == 201) {
        final data = json.decode(response.body);
        return data['success'] == true;
      } else if (response.statusCode == 422) {
        // Validation error from Laravel
        final data = json.decode(response.body);
        throw Exception('Validation error: ${data['message']}');
      } else {
        throw Exception('Failed to save product: ${response.statusCode}');
      }
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }

  Future<List<Product>> fetchProducts() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/api/products'),
        headers: {'Accept': 'application/json'},
      );

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        
        if (data['success'] == true && data['data'] != null) {
          final List<dynamic> productsJson = data['data'];
          return productsJson.map((json) => Product.fromJson(json)).toList();
        } else {
          throw Exception('Failed to load products: ${data['message']}');
        }
      } else {
        throw Exception('Failed to load products: ${response.statusCode}');
      }
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }

  Future<Product?> fetchProduct(int id) async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/api/products/$id'),
        headers: {'Accept': 'application/json'},
      );

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        
        if (data['success'] == true && data['data'] != null) {
          return Product.fromJson(data['data']);
        } else {
          throw Exception('Failed to load product: ${data['message']}');
        }
      } else {
        throw Exception('Failed to load product: ${response.statusCode}');
      }
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }
}