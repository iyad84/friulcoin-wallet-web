friulcoin-lib-php (proto)
===============


PHP libraries implementing (friulcoins) key functions, as well as BIP32 and electrum.

The library it fork from Bitcoin-lib-php intends to expose a lot of general functionality which isn't 
available using the RPC (like deterministic addresses). 
It also allows you to reduce the number of queries,
such as createrawtransaction/signrawtransaction/decoderawtransaction. 
We used: privatekey then generate the Publickey & Address, we used it to create transaction and sign it.


Libraries
=========


- Raw Transactions: create, sign, validate, with support for P2SH. 
- Create multi-signature addresses, create redeeming transactions. 
- We used this function to generate the WIF to extract the address BitcoinLib::WIF_to_private_key().
- The address = BitcoinLib::public_key_to_address(PRV);
- The address we use it to get the unspent value. 
- you need to used advanced blockexplorer to get unspent amount, insight 
	check: http://104.131.45.33:3001/status

Installation  
============
(Important thing to install the library some independences )
------------------------------------------------------------

Installing via Composer (recommended)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

1. Install Composer in your project:

    curl -s http://getcomposer.org/installer | php

2. Create a `composer.json` file in your project root:

    {
        "require": {
            "bitwasp/bitcoin-lib": "1.0.*"
        }
    }

3. Install via Composer

    php composer.phar install




