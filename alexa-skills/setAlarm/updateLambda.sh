FUNNAME=sandman;
FILENAME=$FUNNAME.js
zip $FUNNAME $FILENAME
aws lambda update-function-code --function-name $FUNNAME --zip-file fileb://$FUNNAME.zip


