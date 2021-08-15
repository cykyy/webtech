import requests
from bs4 import BeautifulSoup

from config import get_config


def get_item_id(html):
    """:return: parse and returns an item unique id"""
    from bs4 import BeautifulSoup
    parsed_html = BeautifulSoup(html, features="html.parser")
    return parsed_html.find(id='id_product_id').attrs.get('value')


def add_to_cart(product_url, quantity, session):
    headers = {'User-Agent': 'Mozilla/5.0'}
    r1 = session.get(product_url)  # get request to the product link
    csrf_token = r1.cookies['csrftoken']
    item_id = get_item_id(r1.text)

    payload = {'csrfmiddlewaretoken': csrf_token, 'quantity': quantity, 'product_id': item_id}
    res = session.post(product_url, headers=headers, data=payload)
    # print(res.text)
    return res.status_code


def place_an_order(product_url, qty, name, email, post_code, address, card_name, card_number, card_cvv,
                   expiration_month, expiration_year):
    # print('card_name ', card_name)
    headers = {'User-Agent': 'Mozilla/5.0'}
    session = requests.Session()  # starting a session

    add_to_cart(product_url, qty, session)  # first adding to the cart

    r1 = session.get('http://127.0.0.1:8000/checkout/')  # get request to the product link
    csrf_token = r1.cookies['csrftoken']

    payload = {'csrfmiddlewaretoken': csrf_token, 'name': name, 'email': email,
               'postal_code': int(post_code),
               'address': address, 'card_number': card_number, 'expiration_month': int(expiration_month),
               'expiration_year': int(expiration_year), 'cvv_code': card_cvv, 'card_owner_name': card_name}

    res = session.post('http://127.0.0.1:8000/checkout/', headers=headers, data=payload)
    # print(res.text)
    print(res.status_code)
    return res.status_code


def place_an_order_v2(product_url, qty, card_name='Johns Card', card_number='32323322', card_cvv='111',
                      expiration_month=1, expiration_year=2022):
    print('card_name ', card_name)
    headers = {'User-Agent': 'Mozilla/5.0'}
    session = requests.Session()  # starting a session

    add_to_cart(product_url, qty, session)  # first adding to the cart

    r1 = session.get('http://127.0.0.1:8000/checkout/')  # get request to the product link
    csrf_token = r1.cookies['csrftoken']

    payload = {'csrfmiddlewaretoken': csrf_token, 'name': 'Cartista Doe', 'email': 'john.doe@imail.com',
               'postal_code': '1200',
               'address': 'dummy address, Dhaka, BD', 'card_number': card_number,
               'expiration_month': int(expiration_month),
               'expiration_year': int(expiration_year), 'cvv_code': card_cvv, 'card_owner_name': card_name}

    res = session.post('http://127.0.0.1:8000/checkout/', headers=headers, data=payload)
    print(res.text)
    print(res.status_code)
    return res.status_code


def check_stock(link):
    r1 = requests.get(link)  # get request to the product link

    parsed_html = BeautifulSoup(r1.text, features="html.parser")

    dom_res = parsed_html.find(id='stock').text
    str_bool = dom_res.split()[2]
    if str_bool == 'In':
        return True
    else:
        return False


# add_to_cart('http://127.0.0.1:8000/product/3/item-3/', 5, requests.Session())


def send_mail(mail, sub, msg):
    """Send mail using SMTP"""
    try:
        import smtplib
        from email.mime.multipart import MIMEMultipart
        from email.mime.text import MIMEText
        # print('starting')
        mail_content = msg
        # The mail addresses and password
        sender_address = get_config('mail')
        sender_pass = get_config('pw')
        # print('sender_address', sender_address)
        receiver_address = mail
        # Setup the MIME
        message = MIMEMultipart()
        message['From'] = sender_address
        message['To'] = receiver_address
        message['Subject'] = sub  # The subject line
        # The body and the attachments for the mail
        message.attach(MIMEText(mail_content, 'plain'))
        # Create SMTP session for sending the mail
        session = smtplib.SMTP('smtp.gmail.com', 587)  # use gmail with port
        session.starttls()  # enable security
        session.login(sender_address, sender_pass)  # login with mail_id and password
        text = message.as_string()
        session.sendmail(sender_address, receiver_address, text)
        session.quit()
        print('Mail Sent')
        return True
    except Exception as e:
        print(e)
        print('Sending mail failed!')
        return False
