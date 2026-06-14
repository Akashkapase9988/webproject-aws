data "archive_file" "lambda_zip" {
  type        = "zip"
  source_file = "${path.module}/lambda/insert_record/app.py"
  output_path = "${path.module}/lambda.zip"
}

resource "aws_lambda_function" "Curd_record" {
  function_name = "Curd-operations-lambda"

  filename         = data.archive_file.lambda_zip.output_path
  source_code_hash = data.archive_file.lambda_zip.output_base64sha256

  role    = aws_iam_role.lambda_role.arn
  handler = "app.lambda_handler"
  runtime = "python3.13"

  tags = {
    Environment = "production"
    Name        = "insert-record-lambda"
  }
}