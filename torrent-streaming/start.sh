echo "Installing npms dependencies (node-js): start";
npm install && nvm use 12;
echo "Installing npms dependencies (node-js): done";

echo "Cleaning files directory: start";
rm -rf ~/goinfre/files;
mkdir ~/goinfre/files;
rm files;
ln -s ~/goinfre/files files;
echo "Cleaning files directory: end";
    
echo "Starting node-jd streaming server: start";
npm start;