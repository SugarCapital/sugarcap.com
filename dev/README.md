### local dev with https

The below steps will get you up and running, but if you're curious,
[Full blog post on how to do this](http://www.andrewconnell.com/blog/updated-creating-and-trusting-self-signed-certs-on-macos-and-chrome) (note that the one thing to adjust is that you want the output to be a pem file not crt and key)).

- `composer start`
- `brew install stunnel`
- run `sudo stunnel ./dev/stunnel.config ./dev/local.sugarcap.com.pem`
(to stop it: `sudo killall stunnel`)
- in an incognito window go to [local.sugarcap.com](https://local.sugarcap.com)
- you should get a certificate error which will need to be 'fixed' by clicking on the url to get the certificate info, then drag the certificate into the Keychain Access app and adjust its properties to be always trusted. Note: as of Chrome 72 you can no longer drag/drop the certificate, you can instead do this step with another browser such as Safari.

Now you should be able to hit https://local.sugarcap.com with any browser on your machine.

Obvs, if you restart your machine, you'll need to restart stunnel.

note: command to make cert:

```
 openssl req \
-config ./dev/openssl.cnf \
-new -x509 -sha256 \
-newkey rsa:2048 \
-nodes \
-days 10000 \
-keyout ./dev/local.sugarcap.com.pem \
-out ./dev/local.sugarcap.com.pem
```

### Making your local dev publicly available with https

We have the domain `ngrok.sugarcap.com` registered with ngrok

If you have the keys and cert on your filesystem, you can start with

`ngrok tls 8000 -hostname ngrok.sugarcap.com -key /etc/letsencrypt/live/ngrok.sugarcap.com/privkey.pem -crt /etc/letsencrypt/live/ngrok.sugarcap.com/cert.pem`

The cert will expire in september.  To renew use the command `certbot`.

The state of certs in a the way that `certbot` needs it is backed up to arthur's ~/Documents for now.

Will improve, but wanted to document it :).
### Profiling

1. make sure that `xdebug.profiler_enable_trigger` is set to 1 in your php.ini
2. add the query string pair: `XDEBUG_PROFILE=1`
3. locate the `cachegrind` file in `/var/tmp`
4. open in tool.  I bought MCG from app store for like $25
