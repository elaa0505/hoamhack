FUNNAME=testHTTP;
FILENAME=index.js
#s3BUCKET=hoamhack-alexa-skills;
zip $FUNNAME *
#aws s3 cp $FUNNAME.zip s3://$s3BUCKET
#aws lambda update-function-code --function-name $FUNNAME --zip-file fileb://$FUNNAME.zip


