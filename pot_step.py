import RPi.GPIO as GPIO
import time

GPIO.setmode(GPIO.BCM)

a_pin = 5
b_pin = 6

def discharge():
    GPIO.setup(a_pin, GPIO.IN)
    GPIO.setup(b_pin, GPIO.OUT)
    GPIO.output(b_pin, False)
    time.sleep(0.0047)

def charge_time():
    GPIO.setup(b_pin, GPIO.IN)
    GPIO.setup(a_pin, GPIO.OUT)
    count = 0
    GPIO.output(a_pin, True)
    while not GPIO.input(b_pin):
        count = count + 1
    return count

def analog_read():
    discharge()
    return charge_time()

while True:
	ret = round(analog_read() * 10 / 31)    
	if ret < 5:
		ret = 0
	elif ret >= 5 and ret < 10:
		ret = 5
	elif ret >= 10 and ret < 15:
		ret = 10
	elif ret >= 15 and ret < 20:
		ret = 15
	elif ret >= 20 and ret < 25:
		ret = 20
	elif ret >= 25 and ret < 30:
		ret = 25
	elif ret >= 30 and ret < 35:
		ret = 30
	elif ret >= 35 and ret < 40:
		ret = 35
	elif ret >= 40 and ret < 45:
		ret = 40
	elif ret >= 45 and ret < 50:
		ret = 45
	elif ret >= 50 and ret < 55:
		ret = 50
	elif ret >= 55 and ret < 60:
		ret = 55
	elif ret >= 60 and ret < 65:
		ret = 60
	elif ret >= 65 and ret < 70:
		ret = 65
	elif ret >= 70 and ret < 75:
		ret = 70
	elif ret >= 75 and ret < 80:
		ret = 75
	elif ret >= 80 and ret < 85:
		ret = 80
	elif ret >= 85 and ret < 90:
		ret = 85
	elif ret >= 90 and ret < 95:
		ret = 90
	elif ret >= 95:
		ret = 95

	print(ret)

	time.sleep(1)