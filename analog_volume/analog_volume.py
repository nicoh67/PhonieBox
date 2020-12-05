import wiringpi

pin_a = 23
pin_b = 24
lastEncoded = 0

def gpio_callback():
   print("GPIO_CALLBACK!")
   MSB = wiringpi.digitalRead(pin_a)
   LSB = wiringpi.digitalRead(pin_b)
   encoded = (MSB << 1) | LSB
#   sum = (lastEncoded << 2) | encoded
#   lastEncoded = encoded
   print(encoded)
   print(sum)
   print(MSB)
   print(LSB)




wiringpi.wiringPiSetupGpio()
wiringpi.pinMode(pin_a, wiringpi.GPIO.INPUT)
wiringpi.pinMode(pin_b, wiringpi.GPIO.INPUT)
wiringpi.pullUpDnControl(pin_a, wiringpi.GPIO.PUD_UP)
wiringpi.pullUpDnControl(pin_b, wiringpi.GPIO.PUD_UP)

wiringpi.wiringPiISR(pin_a, wiringpi.GPIO.INT_EDGE_BOTH, gpio_callback);
wiringpi.wiringPiISR(pin_b, wiringpi.GPIO.INT_EDGE_BOTH, gpio_callback);


while True:
	wiringpi.delay(1)