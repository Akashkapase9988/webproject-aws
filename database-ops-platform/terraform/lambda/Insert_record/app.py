import json
import boto3

dynamodb = boto3.resource('dynamodb')
table = dynamodb.Table('example-table')

def lambda_handler(event, context):

    method = event["requestContext"]["http"]["method"]
    body = json.loads(event["body"]) if event.get("body") else {}

    if method == "POST":
        table.put_item(Item={
            "db_id": body["db_id"],
            "name": body["name"],
            "engine": body["engine"]
        })

        return {
            "statusCode": 200,
            "body": json.dumps("Record inserted")
        }

    elif method == "PUT":
        table.update_item(
            Key={"db_id": body["db_id"]},
            UpdateExpression="SET #n = :n, engine = :e",
            ExpressionAttributeNames={"#n": "name"},
            ExpressionAttributeValues={
                ":n": body["name"],
                ":e": body["engine"]
            }
        )

        return {
            "statusCode": 200,
            "body": json.dumps("Record updated")
        }

    elif method == "DELETE":
        table.delete_item(
            Key={"db_id": body["db_id"]}
        )

        return {
            "statusCode": 200,
            "body": json.dumps("Record deleted")
        }

    return {
        "statusCode": 400,
        "body": json.dumps("Unsupported method")
    }