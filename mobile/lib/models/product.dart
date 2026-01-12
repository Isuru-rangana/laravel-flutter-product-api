class Product {
  final int? id;
  final String name;
  final int categoryId;
  final double price;
  final bool active;

  Product({
    this.id,
    required this.name,
    required this.categoryId,
    required this.price,
    required this.active,
  });

  // Factory constructor to create a Product from JSON
  factory Product.fromJson(Map<String, dynamic> json) {
    return Product(
      id: json['id'],
      name: json['name'],
      categoryId: json['category_id'],
      // Ensures price is always treated as a double
      price: double.parse(json['price'].toString()),
      active: json['active'] is int ? json['active'] == 1 : json['active'],
    );
  }

  // Method to convert Product object to JSON for the Laravel API POST request
  Map<String, dynamic> toJson() {
    return {
      'name': name,
      'category_id': categoryId,
      'price': price,
      'active': active,
    };
  }

  @override
  String toString() => 'Product(id: $id, name: $name, price: $price)';
}