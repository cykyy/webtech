#!/Users/rayhanmia/PycharmProjects/cartista-bot/venv/py/bin/python3
import time

import mysql.connector
import service


class MyDb:
    mydb = mysql.connector.connect(
        host="127.0.0.1",
        user="root",
        password="root",
        database="project",
        port=8889
    )

    mycursor = mydb.cursor()

    def query(self, query):
        """supply query, returns object"""
        self.mycursor.execute(query)
        return self.mycursor

    def get_all_trackers(self):
        """returns all trackers from db"""
        self.mycursor.execute("SELECT * FROM trackers")
        myresult = self.mycursor.fetchall()
        """for x in myresult:
            print(x)
            print(type(x))
        print(myresult)
        print(type(myresult))"""
        return myresult

    def update_tracker_to_order_qty(self, uri_id, remote_status, to_order_qty, ordered):
        """returns info of user"""
        sql = "UPDATE trackers SET OrderQty = %s,RemoteStatus = %s, Ordered = %s WHERE ID = %s"
        val = (to_order_qty, remote_status, ordered, uri_id)

        try:
            self.mycursor.execute(sql, val)
            self.mydb.commit()
        except Exception as e:
            print(e)
            return []

    def update_tracker_stock_status(self, uri_id, remote_status):
        """returns info of user"""
        sql = "UPDATE trackers SET RemoteStatus = %s WHERE ID = %s"
        val = (remote_status, uri_id)

        try:
            self.mycursor.execute(sql, val)
            self.mydb.commit()
        except Exception as e:
            print(e)
            return []

    def get_user_info(self, username):
        """returns info of user"""
        sql = "SELECT * FROM user_info WHERE Username = %s"
        inp = (username,)
        try:
            self.mycursor.execute(sql, inp)
            myresult = self.mycursor.fetchall()
            return myresult
        except Exception as e:
            print(e)
            return []

    def get_user_payment_info(self, username):
        """returns payment info of user"""
        # print('username', username)
        sql = "SELECT * FROM user_payment_info WHERE Username = %s"
        inp = (username,)
        try:
            self.mycursor.execute(sql, inp)
            myresult = self.mycursor.fetchall()
            # print('myresult', myresult)
            return myresult
        except Exception as e:
            print(e)
            return []


# print(obj.query("SELECT * FROM trackers").fetchall())

try:
    print('Bot Starting...')
    obj = MyDb()
    while True:
        trackers = obj.get_all_trackers()
        print('trackers', trackers)
        results = []
        for tracker in trackers:
            # expanding list of tuple
            # print(tracker)
            # print(tracker[1])
            user_info = obj.get_user_info(tracker[4])

            cartista_stock_stat = tracker[2]
            # print('cartista_stock_stat', cartista_stock_stat)
            if 'In' in cartista_stock_stat:
                cartista_stock_stat_bool = True
                # print('stock innnn')
            else:
                cartista_stock_stat_bool = False
                # print('stock outttt')

            stock_stat = service.check_stock(link=tracker[1])

            if stock_stat != cartista_stock_stat_bool:
                if stock_stat:
                    obj.update_tracker_stock_status(tracker[0], 'Stock-In')
                    service.send_mail(mail=user_info[0][2], msg=f'UPDATE! STOCK IN FOR THE LINK {tracker[1]} . ',
                                      sub='Cartista Bot Product Stock Update - STOCK-IN')
                else:
                    obj.update_tracker_stock_status(tracker[0], 'Stock-Out')
                    service.send_mail(mail=user_info[0][2], msg=f'UPDATE! STOCK OUT FOR THE LINK {tracker[1]} . ',
                                      sub='Cartista Bot Product Stock Update - STOCK-OUT')

            # print('stock_stat', stock_stat)
            if stock_stat:
                # print('stock in! great!')

                user_payment_info = obj.get_user_payment_info(tracker[4])
                # print('user_info', user_info)
                # print('user_payment_info', user_payment_info)
                # print(tracker)
                if user_payment_info:
                    if tracker[3] > 0:
                        response = service.place_an_order(
                            product_url=tracker[1],
                            qty=tracker[3],
                            name=user_info[0][1],
                            email=user_info[0][2],
                            post_code=user_payment_info[0][7],
                            address=user_payment_info[0][8],
                            card_name=user_payment_info[0][2],
                            card_number=user_payment_info[0][3],
                            card_cvv=user_payment_info[0][4],
                            expiration_month=user_payment_info[0][5],
                            expiration_year=user_payment_info[0][6]
                        )
                        if response == 200:
                            print('Successfully placed an order!')
                            results.append({'username': tracker[4], 'uri:': tracker[1], 'quantity': tracker[3]})

                            if stock_stat:
                                _rm_stat = 'Stock-In'
                            else:
                                _rm_stat = 'Stock-Out'
                            obj.update_tracker_to_order_qty(
                                uri_id=tracker[0],
                                to_order_qty=0,
                                remote_status=_rm_stat,
                                ordered=tracker[3],
                            )
                else:
                    print('User:', tracker[4], "don't have any payment info! skipping..")

            else:
                # if stock is out
                pass

        print('ordered results:', results)
        print('Bot ending..')
        time.sleep(10)  # interval of 10sec

except Exception as e:
    print(e)
    print('Something went wrong. Bot Exited Unexpectedly!')
