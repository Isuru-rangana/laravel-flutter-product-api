import 'package:flutter/material.dart';
import '../models/category.dart';
import '../models/product.dart';
import '../services/api_service.dart';

class ProductFormScreen extends StatefulWidget {
  @override
  _ProductFormScreenState createState() => _ProductFormScreenState();
}

class _ProductFormScreenState extends State<ProductFormScreen> {
  final _formKey = GlobalKey<FormState>();
  final ApiService _apiService = ApiService();

  final TextEditingController _nameController = TextEditingController();
  final TextEditingController _priceController = TextEditingController();
  int? _selectedCategoryId;
  bool _isActive = true; 
  List<Category> _categories = [];
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    _loadCategories();
  }

  Future<void> _loadCategories() async {
    try {
      final categories = await _apiService.fetchCategories();
      setState(() {
        _categories = categories;
        _isLoading = false;
      });
    } catch (e) {
      setState(() => _isLoading = false);
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Error loading categories')),
      );
    }
  }

  Future<void> _submitForm() async {
    if (_formKey.currentState!.validate()) {
      final newProduct = Product(
        name: _nameController.text,
        categoryId: _selectedCategoryId!,
        price: double.parse(_priceController.text),
        active: _isActive,
      );

      final success = await _apiService.saveProduct(newProduct);
      if (success) {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Product added successfully!')),
        );
        _formKey.currentState!.reset();
        _nameController.clear();
        _priceController.clear();
        setState(() {
          _selectedCategoryId = null;
          _isActive = true;
        });
      } else {
        ScaffoldMessenger.of(context).showSnackBar(
          SnackBar(content: Text('Failed to add product.')),
        );
      }
    }
  }

  @override
  void dispose() {
    _nameController.dispose();
    _priceController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Add New Product')),
      body: _isLoading 
          ? Center(child: CircularProgressIndicator())
          : Padding(
              padding: const EdgeInsets.all(16.0),
              child: Form(
                key: _formKey,
                child: ListView(
                  children: [
                    TextFormField(
                      controller: _nameController,
                      decoration: InputDecoration(labelText: 'Product Name'),
                      validator: (value) => value!.isEmpty ? 'Enter name' : null,
                    ),
                    SizedBox(height: 16),

                    DropdownButtonFormField<int>(
                      value: _selectedCategoryId,
                      hint: Text('Select Category'),
                      items: _categories.map((cat) {
                        return DropdownMenuItem(value: cat.id, child: Text(cat.name));
                      }).toList(),
                      onChanged: (val) => setState(() => _selectedCategoryId = val),
                      validator: (val) => val == null ? 'Select a category' : null,
                    ),
                    SizedBox(height: 16),

                    TextFormField(
                      controller: _priceController,
                      decoration: InputDecoration(labelText: 'Price'),
                      keyboardType: TextInputType.number,
                      validator: (value) {
                        if (value!.isEmpty) return 'Enter price';
                        if (double.tryParse(value) == null) return 'Enter valid price';
                        return null;
                      },
                    ),
                    SizedBox(height: 16),

                    SwitchListTile(
                      title: Text('Is Active?'),
                      value: _isActive,
                      onChanged: (val) => setState(() => _isActive = val),
                    ),
                    SizedBox(height: 32),

                    ElevatedButton(
                      onPressed: _submitForm,
                      child: Text('Save Product'),
                    ),
                  ],
                ),
              ),
            ),
    );
  }
}