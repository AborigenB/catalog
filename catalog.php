<?
class Catalog {
    private $products = [];

    public function addProduct($product) {
        $this->products[] = $product;
    }

    public function getProducts() {
        return $this->products;
    }

    public function searchProducts($query) {
        return array_filter($this->products, function($product) use ($query) {
            return stripos($product->name, $query) !== false;
        });
    }

    public function filterProductsByCategory($category) {
        return array_filter($this->products, function($product) use ($category) {
            return $product->category === $category;
        });
    }

    public function filterAndSearch($query, $category) {
        $filtered = $this->searchProducts($query);
        if ($category) {
            $filtered = $this->filterProductsByCategory($category);
        }
        return $filtered;
    }
}