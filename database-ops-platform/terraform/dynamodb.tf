resource "aws_dynamodb_table" "database_inventory" {
  name         = "example-table"
  billing_mode = "PAY_PER_REQUEST"

  attribute {
    name = "db_id"
    type = "S"
  }

  hash_key = "db_id"
  tags = {
    Environment = "production"
    Name        = "example-table"
  }
}
